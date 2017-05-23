<?php

namespace App\Http\Controllers\Users;

use App\Models\Users\User as User;
use App\Models\Roles\Role as Role;
use App\Models\Users\Level as Level;
use App\Models\Users\Stream as Stream;
use App\Models\Users\Period as Period;
use App\Models\Users\UserGroup as UserGroup;
use App\Models\Communities\Community as Community;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserListController extends Controller
{
    /**
     * The attributes that can be sorted.
     *
     * @var array
     */
    protected $sortable = ['first_name', 'last_name', 'created_at'];

    /**
     * The attributes that can be filtred.
     *
     * @var array
     */
    protected $filtrable = ['role', 'community', 'level', 'period', 'stream', 'status'];

    /**
     * The defaults for sorting.
     *
     * @var array
     */
    protected $sortDefault = [
        'sort' => 'last_name',
        'order' => 'asc',
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function index(Request $request)
    {
        //Get usergroup
        $userGroup = \Route::input('usergroup');

        // Check if user can see resource
        if (\Gate::denies('view', 'user')) {
            abort(403);
        }

        //Get query string
        $queryString = $request->query();
       
        //Build DB query
        if ($userGroup->group == 'parents') {
            //For user group 'parents' leading list is students list
            $query = User::where('user_group_id', UserGroup::where('group', 'students')->firstOrFail()->id)->with('parent');
        } else {
            $query = User::where('user_group_id', $userGroup->id);
        }
      
        $query = $this->getFilter($query, $queryString);

        if (isset($queryString['search'])) {
            //Flash search request to the session
            $request->flashOnly('search');
            //Call for handler
            $query = $this->searchHandler($query, $queryString);
        }
   
        $sort = $this->getSort($userGroup, $queryString);

        $list = $query->orderBy($sort['sort'], $sort['order'])->paginate(5);
        
        return view('admin.users.index', [
            'list' => $list,
            'slug' => 'usergroup/'.$userGroup->group.'/user',
            'communities' => Community::all(),
            'usergroup' => $userGroup->group,
            'roles' => Role::all(),
            'levels' => Level::all(),
            'streams' => Stream::all(),
            'periods' => Period::all(),
            'session' => \Session::get($userGroup->group),
        ]);
    }

    
    /**
     * Apply fiters to query builder
     *
     * @param Illuminate/Database/Eloquent/Builder $query
     * @param array $queryString
     *
     * @return Illuminate/Database/Eloquent/Builder $query
     *
    */
    protected function getFilter($query, $queryString)
    {
        for ($i=0; $i<count($this->filtrable); $i++) {
            //Get input
            $attribute = "";
            $filter = false;

            if (isset($queryString[$this->filtrable[$i]])) {
                $attribute = $queryString[$this->filtrable[$i]];
                $filter = true;
            }
                      
            //Get filter class name
            $className = 'App\Services\Users\Filters\\'.ucfirst($this->filtrable[$i]).'Filter';

            //Apply filter
            if (class_exists($className)) {
                $filterInst = new $className;
                $query = $filterInst->filter($query, $filter, $attribute);
            }
        }

        return $query;
    }

    /**
     * Get sort query.
     *
     * @param Illuminate/Database/Eloquent/Builder $query
     * @param array $queryString
     *
     * @return array
    */
    protected function getSort($userGroup, $queryString)
    {
        //Get key for sorting.
        if (isset($queryString['sort'])) {
            $sort = $queryString['sort'];

            //Check if given value in the sortable scope.
            if (!in_array($sort, $this->sortable, true)) {
                abort(404);
            }
        } else {
            $sort = session(''.$userGroup->group.'.sort', $this->sortDefault['sort']);
        }
   
        //Get value for sorting.
        if (isset($queryString[$sort])) {
            $order = $queryString[$sort];
        } else {
            $order = session(''.$userGroup->group.'.order', $this->sortDefault['order']);
        }

        //Store sort data in the session
        session([''.$userGroup->group.'.sort' => $sort]);
        session([''.$userGroup->group.'.order' => $order]);

        return ['sort' => $sort, 'order' => $order];
    }

    /**
     * Search in the user list.
     *
     * @param Illuminate/Database/Eloquent/Builder $query
     * @param array $queryString
     *
     * @return Illuminate/Database/Eloquent/Builder $query
     */
    public function searchHandler($query, $queryString)
    {
        return $query
            ->where('last_name', 'like', $queryString['search'].'%')
            ->orWhere('email', 'like', $queryString['search'].'%');
    }
}
