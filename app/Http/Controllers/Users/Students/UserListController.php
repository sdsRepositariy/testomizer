<?php

namespace App\Http\Controllers\Users\Students;

use App\Models\Users\User as User;
use App\Models\Roles\Role as Role;
use App\Models\Users\Level as Level;
use App\Models\Users\Stream as Stream;
use App\Models\Users\Period as Period;
use App\Models\Users\Grade as Grade;
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
        $filterGrade = array();

        if (isset($queryString['community']) && \Gate::allows('create', 'user')) {
            $filterUser['community'] = $queryString['community'];
        } else {
            $filterUser['community'] = \Auth::user()->community_id;
        }

        if (isset($queryString['status'])) {
            $filterUser['status'] = $queryString['status'];
        } else {
            $filterUser['status'] = 'active';
        }

        if (isset($queryString['level'])) {
            $filterGrade['level'] = $queryString['level'];
        } else {
            $filterGrade['level'] = null;
        }

        if (isset($queryString['stream'])) {
            $filterGrade['stream'] = $queryString['stream'];
        } else {
            $filterGrade['stream'] = null;
        }

        if (isset($queryString['period'])) {
            $filterGrade['period'] = $queryString['period'];
        } else {
            $period = new Period();
            $filterGrade['period'] = $period->getCurrentPeriodId();
        }

        //Search
        if (isset($queryString['search'])) {
            $search = $queryString['search'];
        } else {
            $search = null;
        }

        //Get grades id
        $grade = new Grade();
        $gradesId = $grade->getGradesId($filterUser['community'], $filterGrade);

        //Get user list
        $user = new User();
        $list = $user->getStudents($sort, $order, $filterUser, $gradesId, $search);
        
        //Make query string for sorting
        $path = 'usergroup/students';

        $url = url($path, 'list').'?';

        $url .= http_build_query(array_merge($filterGrade, $filterUser));

        $url .= '&sort='.$sort.'&order='.$order;

        if (!empty($search)) {
            $url .= '&search='.$search;
        }

        //Levels, streams, periods should be related to certain community
        $selectedCommunity = Community::find($filterUser['community']);

        //The community may have diferent quantity of levels and streams
        //depending on a period. So to get right lists of levels and
        //streams we need to select it for certain period and get unique lists.
        $streams = $selectedCommunity->streams()->where('period_id', $filterGrade['period'])->get()->unique('id');

        $levels = $selectedCommunity->levels()->where('period_id', $filterGrade['period'])->get()->unique('id');

        $periods = $selectedCommunity->periods()->get()->unique('id');

        return view('admin.users.students.index', [
            'list' => $list,
            'url' => $url,
            'path' => $path,
            'communities' => Community::all(),
            'communityDefault' => \Auth::user()->community_id,
            'levels' => $levels,
            'streams' => $streams,
            'periods' => $periods,
            'filterGrade' => $filterGrade,
            'filterUser' => $filterUser,
        ]);
    }
}
