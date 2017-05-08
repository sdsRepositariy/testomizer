<?php

namespace App\Http\Controllers\Users;

use App\Models\Roles\Role as Role;
use App\Models\Roles\Permission as Permission;
use App\Models\Communities\Community as Community;
use App\Models\Users\User as User;
use App\Models\Users\UserGroup as UserGroup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserListController extends Controller
{
    /**
     * The request instance.
     *
     * @var request instance
    */
    protected $request;

    /**
     * The usergroup name.
     *
     * @var string
    */
    protected $usergroup;
   
    /**
     * The query string for recieved request.
     *
     * @var array
    */
    protected $queryString;

    /**
     * The set of possible query keys.
     *
     * @var array
     */
    protected $keyable = ['filter', 'sort', 'search'];

    /**
     * The attributes that can be sorted.
     *
     * @var array
     */
    protected $sortable = ['first_name', 'last_name', 'created_at'];

    /**
     * The sort orders.
     *
     * @var array
     */
    protected $orderable = ['asc', 'desc'];

    /**
     * The attributes that can be filtred.
     *
     * @var array
     */
    protected $filtrable = ['role', 'community', 'level', 'period', 'stream', 'status'];

    /**
     * The defaults for sorting and filtering.
     *
     * @var array
     */
    protected $userListDefault = [
        'orderby' => 'last_name',
        'order' => 'asc',
        'role' => 'all',
        'status' => 'active',
        'community' => 'my_community',
    ];

    /**
     * Get query data depends on requested resource.
     *
     * @param  Illuminate\Http\Request  $request
     * @return void
    */
    public function __construct(Request $request)
    {
        $this->queryString = $request->query();
 
        $this->request = $request;
      
        $this->usergroup = \Route::input('usergroup');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function index()
    {
        // $this->authorize('view', User::class);
        
        if (!empty($this->queryString)) {
            //Check query keys
            $this->checkKeys($this->queryString);
        } else {
            $this->queryString = "";
        }
        // $this->request->session()->flush();
        //Call handlers
        // $search = $this->searchHandler();
        // $sort = $this->sortHandler();
        // $role = $this->roleFilter();
        // $status = $this->statusFilter();
        // $community = $this->communityFilter();
         
        $queryInput = $this->getInput();
    
        
        
        //Get user instance
        $user = \Auth::user();

        //Get user group id
        // $userGroupId = UserGroup::where('group', $this->usergroup)->firstOrFail()->id;
      
        // //Build DB query
        // $list = User::where('user_group_id', $userGroupId)
        //     ->when($role['filter'], function ($query) use ($role) {
        //         return $query->where('role_id', $role['roleid']);
        //     })
        //     ->when($community['filter'], function ($query) use ($community) {
        //         return $query->where('community_id', $community['communityid']);
        //     })
        //     ->when($status['filter'], function ($query) use ($status) {
        //         return $query->where('users.deleted_at', $status['operator'], null);
        //     })
        //     ->when($search, function ($query) use ($search) {
        //         return $query
        //             ->where('last_name', 'like', $this->queryString['search'].'%')
        //             ->orWhere('email', 'like', $this->queryString['search'].'%');
        //     })
        //     ->orderBy($sort['orderby'], $sort['order'])
        //     ->withTrashed()
        //     ->paginate(5);
        //Get user group id
        $userGroupId = UserGroup::where('group', $this->usergroup)->firstOrFail()->id;
      
        //Build DB query
        $list = User::where('user_group_id', $userGroupId)
            ->when($queryInput['role']!='all', function ($query) use ($queryInput) {
                $roleId = Role::where('role', $queryInput['role'])
                ->firstOrFail()
                ->id;
                return $query->where('role_id', $roleId);
            })
            ->when($queryInput['community']!='all', function ($queryInput) use ($community) {
               
                return $query->where('community_id', $community['communityid']);
            })->get();
            // ->when($status['filter'], function ($query) use ($queryInput) {
            //     return $query->where('users.deleted_at', $status['operator'], null);
            // })
            // ->when($search, function ($query) use ($queryInput) {
            //     return $query
            //         ->where('last_name', 'like', $this->queryString['search'].'%')
            //         ->orWhere('email', 'like', $this->queryString['search'].'%');
            // })
            // ->orderBy($sort['orderby'], $sort['order'])
            // ->withTrashed()
            // ->paginate(5);
        //Get communities
        $communities = Community::all();
        dd($list);
        return view('admin.users.index', [
            'list' => $list,
            'communities' => $communities,
            'usergroup' => $this->usergroup,
            'session' => \Session::get($this->usergroup)
        ]);
    }

    /**
     * Get inputs
     *
     * @return
     *
    */
    protected function getInput()
    {
        foreach ($this->userListDefault as $key => $value) {
            if (isset($this->queryString[$key])) {
                $queryInput[$key] = $this->queryString[$key];
            } else {
                $queryInput[$key] = $this->request->session()
                ->get(''.$this->usergroup.'.'.$key.'', $value);
            }
                      
           //Store data in the session
            $this->request->session()->put(''.$this->usergroup.'.'.$key.'', $queryInput[$key]);
        }
  
        return $queryInput;
    }


    /**
     * Search in user list.
     *
     * @return bool
     */
    public function searchHandler()
    {
        if (isset($this->queryString['search'])) {
            //Reset role filter
            $this->request->session()->put(''.$this->usergroup.'.role', 'all');
            
            //Flash search request to the session
            $this->request->flashOnly('search');
            
            //Return search indicator
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get key and value for sorting.
     *
     * @return array
    */
    protected function sortHandler()
    {
        //Get key for sorting.
        if (isset($this->queryString['orderby'])) {
            $orderBy = $this->checkSortValue('orderby', $this->queryString['orderby']);
        } else {
            $orderBy = $this->request->session()
                ->get(''.$this->usergroup.'.orderby', $this->userListDefault['orderby']);
        }
   
        //Get value for sorting.
        if (isset($this->queryString['order'])) {
            $order = $this->checkSortValue('order', $this->queryString['order']);
        } else {
            $order = $this->request->session()
                ->get(''.$this->usergroup.'.order', $this->userListDefault['order']);
        }

        return ['orderby' => $orderBy, 'order' => $order];
    }

    /**
     * Get role ID for role filter.
     *
     * @return array
    */
    protected function roleFilter()
    {
        //Get role value
        if (isset($this->queryString['role'])) {
            $role = $this->queryString['role'];
        } else {
            $role = $this->request->session()
                ->get(''.$this->usergroup.'.role', $this->userListDefault['role']);
        }

        //Get role ID for resource members
        $roleId = '';
        $filter = true;

        if ($role == 'all') {
            $filter = false;
        } else {
            $roleId = Role::where('role', $role)
                ->firstOrFail()
                ->id;
        }

        return ['role' => $role, 'roleid' => $roleId, 'filter' => $filter];
    }

    /**
     * Get data for status filter.
     *
     * @return array
    */
    protected function statusFilter()
    {
        //Get status value
        if (isset($this->queryString['status'])) {
            $status = $this->queryString['status'];
        } else {
            $status = $this->request->session()
                ->get(''.$this->usergroup.'.status', $this->userListDefault['status']);
        }

        //Get status fields.
        $filter = true;
        $operator = "";

        switch ($status) {
            case 'all':
                $filter = false;
                break;
            case 'active':
                $operator = '=';
                break;
            case 'deleted':
                $operator = '<>';
                break;
            default:
                abort(404);
        }
       
        return ['status' => $status,
                'operator' => $operator,
                'filter' => $filter
        ];
    }

     /**
     * Get community ID's for community filter.
     *
     * @return array
    */
    protected function communityFilter()
    {
        //Get community value
        if (isset($this->queryString['community'])) {
            $community = $this->queryString['community'];
        } else {
            $community = $this->request->session()
                ->get(''.$this->usergroup.'.community', $this->userListDefault['community']);
        }

       //Get community ID's.
       
        $user = \Auth::user();

        $communityId = '';
        $filter = true;

        //Community can select superadmin only, so we need to check if
       //the user is superadmin.
        if (\Gate::allows('view', 'community')) {
            switch ($community) {
                case 'all':
                    $filter = false;
                    break;
                case 'my_community':
                    $communityId = $user->community_id;
                    break;
                default:
                    $communityId = Community::findOrFail($community)->id;
                    break;
            }
        } else {
            $communityId = $user->community_id;
        }


        return [
            'community' => $community,
            'communityid' => $communityId,
            'filter' => $filter,
        ];
    }

    
    /**
     * Check if given keys in the keyable scope.
     *
     * @return bool
    */
    protected function checkKeys()
    {
        $difference = array_diff(array_keys($this->queryString), $this->keyable);
        if (!empty($difference)) {
            abort(404);
        }
        return true;
    }

    /**
     * Check if given value in the sortable scope.
     *
     * @param string $sortKey
     * @param string $sortValue
     * @return string
    */
    protected function checkSortValue($sortKey, $sortValue)
    {
        if (!in_array($sortValue, $this->sortable[$sortKey], true)) {
            abort(404);
        }
        return $sortValue;
    }
}
