<?php

namespace App\Http\Controllers\Users\Parents;

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
    protected $sortable = ['level', 'stream', 'student_last_name', 'last_name'];

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
        'sort' => 'student_last_name',
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

        if (isset($queryString['community']) && \Gate::allows('create', 'community')) {
            $filterUser['community'] = $queryString['community'];
        } else {
            $filterUser['community'] = \Auth::user()->community_id;
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
            $lastPeriod = Community::find(($filterUser['community']))->periods()->get()->last();
            if ($lastPeriod != null) {
                $filterGrade['period'] = $lastPeriod->id;
            } else {
                $filterGrade['period'] = null;
            }
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
        $list = $user->getParents($sort, $order, $filterUser, $gradesId, $search)->paginate(7);
        
        // Build query string for sorting.
        $queryString = '?';

        // We need query part with filters without sort to handle sorting
        $queryString .= http_build_query(array_merge($filterGrade, $filterUser));

        if (!empty($search)) {
            $queryString .= '&search='.$search;
        }

        // Query with sort
        $queryStringWithSort = $queryString.'&'.http_build_query(['sort' => $sort, 'order' => $order]);

        //Build url with query string
        $path = 'usergroup/parents';

        $url = url($path, 'list');

        $url .= $queryStringWithSort;

        $list->setPath($url);

        //Store some data in the session for further use
        session([
            'parents_user_list' => $url.'&page='.$list->currentPage(),
            'parents_filter_community' => $filterUser['community'],
            'parents_filter_grade' => $filterGrade
        ]);

        //Inverse sort order to make a loop for sorting
        if ($order == 'asc') {
            $order = 'desc';
        } else {
            $order = 'asc';
        }

        //Levels, streams, periods should be related to certain community
        $selectedCommunity = Community::find($filterUser['community']);

        //The community may have diferent quantity of levels and streams
        //depending on a period. So to get right lists of levels and
        //streams we need to select it for certain period and select items
        //with unique id's.
        $streams = $selectedCommunity->streams()->where('period_id', $filterGrade['period'])->orderBy('name', 'asc')->get()->unique('id');

        $levels = $selectedCommunity->levels()->where('period_id', $filterGrade['period'])->orderBy('number', 'asc')->get()->unique('id');

        $periods = $selectedCommunity->periods()->get()->unique('id');

        return view('admin.users.parents.index', [
            'list' => $list,
            'queryString' => $queryString,
            'queryStringWithSort' => $queryStringWithSort,
            'path' => $path,
            'communities' => Community::all(),
            'grades' => Grade::find($filterGrade['period']),
            'levels' => $levels,
            'streams' => $streams,
            'periods' => $periods,
            'filterGrade' => $filterGrade,
            'filterUser' => $filterUser,
            'sort' => $sort,
            'order' => $order,
        ]);
    }
}
