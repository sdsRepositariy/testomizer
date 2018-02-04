<?php

namespace App\Http\Controllers\Users\Teachers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Users\User as User;
use App\Models\Roles\Role as Role;
use App\Models\Users\UserGroup as UserGroup;
use App\Models\Communities\Community as Community;

class UserListController extends Controller
{
    /**
     * The attributes that can be sorted.
     *
     * @var array
     */
    protected $sortable = ['role', 'last_name'];

    /**
     * The sort orders.
     *
     * @var array
     */
    protected $sortOrder = ['asc', 'desc'];

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
    public function getList(Request $request)
    {
        // Check if user can see resource
        if (\Gate::denies('view', 'user')) {
            abort(403);
        }

        //Get query string
        $queryString = $request->query();

        //Sort
        if (isset($queryString['sort']) && in_array($queryString['sort'], $this->sortable, true)) {
            $sort = $queryString['sort'];
        } else {
            $sort = $this->sortDefault['sort'];
        }

        if (isset($queryString['order']) && in_array($queryString['order'], $this->sortOrder, true)) {
            $order = $queryString['order'];
        } else {
            $order = $this->sortDefault['order'];
        }

        //Filters
        //Filters recieve id's exept the status filter
        $filterUser = array();

        if (isset($queryString['community']) && \Gate::allows('create', 'community')) {
            $filterUser['community'] = $queryString['community'];
        } else {
            $filterUser['community'] = \Auth::user()->community_id;
        }

        if (isset($queryString['status'])) {
            $filterUser['status'] = $queryString['status'];
        } else {
            $filterUser['status'] = 'active';
        }

        if (isset($queryString['role'])) {
            $filterUser['role'] = $queryString['role'];
        } else {
            $filterUser['role'] = null;
        }

        //Search
        if (isset($queryString['search'])) {
            $search = $queryString['search'];
        } else {
            $search = null;
        }

        //Get user list
        $user = new User();
        $list = $user->getTeachers($sort, $order, $filterUser, $search)->paginate(7);

        // Build query string for sorting.
        $queryString = '?';

        // We need query part with filters without sort to handle sorting
        $queryString .= http_build_query($filterUser);

        if (!empty($search)) {
            $queryString .= '&search='.$search;
        }

        // Query with sort
        $queryStringWithSort = $queryString.'&'.http_build_query(['sort' => $sort, 'order' => $order]);

        //Build url with query string
        $path = 'usergroup/teachers';

        $url = url($path, 'list');

        $url .= $queryStringWithSort;

        $list->setPath($url);

        //Store some data in the session for further use
        session([
            'teachers_user_list' => $url.'&page='.$list->currentPage(),
            'teachers_filter_community' => $filterUser['community'],
            'teachers_filter_role' => $filterUser['role']
        ]);

        //Inverse sort order to make a loop for sorting
        if ($order == 'asc') {
            $order = 'desc';
        } else {
            $order = 'asc';
        }

        //Get roles wich belongs to community
        $selectedCommunity = Community::find($filterUser['community']);

        $usergroupId = UserGroup::where('group', 'teachers')->first()->id;

        $roles = $selectedCommunity->roles()->where('user_group_id', $usergroupId)->orderBy('role', 'asc')->get()->unique('id');

        return view('admin.users.teachers.index', [
            'list' => $list,
            'queryString' => $queryString,
            'queryStringWithSort' => $queryStringWithSort,
            'path' => $path,
            'communities' => Community::all(),
            'roles' => $roles,
            'filterUser' => $filterUser,
            'sort' => $sort,
            'order' => $order,
        ]);
    }
}
