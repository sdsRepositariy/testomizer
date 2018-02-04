<?php

namespace App\Http\Controllers\Communities;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Communities\Community as Community;
use App\Models\Communities\City as City;
use App\Models\Communities\Region as Region;
use App\Models\Communities\Country as Country;
use App\Models\Communities\CommunityType as Type;
use App\Http\Requests\ValidateCommunityForm as ValidateCommunityForm;

class CommunityController extends Controller
{
    /**
     * The attributes that can be sorted.
     *
     * @var array
     */
    protected $sortable = ['country', 'region', 'city', 'community_type', 'number', 'name'];

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
        'sort' => 'city',
        'order' => 'asc',
    ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Check if user can see resource
        if (\Gate::denies('view', 'community')) {
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
        //Filters recieve id's except the status filter.
        $filter = array();

        //Country
        if (isset($queryString['country'])) {
            $filter['country'] = $queryString['country'];
        } else {
            $filter['country'] = \Auth::user()->community->city->region->country->id;
        }

        //Region
        if (isset($queryString['region'])) {
            $filter['region'] = $queryString['region'];
        } else {
            $filter['region'] = null;
        }

        //City
        if (isset($queryString['city'])) {
            $filter['city'] = $queryString['city'];

            if (!isset($queryString['region'])) {
                //Set region for the given city
                $filter['region'] = City::find($filter['city'])->region->id;
            }
        } else {
            $filter['city'] = null;
        }

        if (isset($queryString['community_type'])) {
            $filter['community_type'] = $queryString['community_type'];
        } else {
            $filter['community_type'] = null;
        }

        //Get lists for filters
        $countries = Country::all();

        $regions =  $this->getFilterList($filter, 'regions.*', true);

        $cities = $this->getFilterList($filter, 'cities.*', true);

        $types = Type::whereIn(
            'id',
            $this->getFilterList($filter, 'communities.community_type_id')
                  ->pluck('community_type_id')
                  ->toArray()
        )->get();
        
        //Get community list
        $community = new Community();
        $list = $community->getCommunities($filter, $sort, $order)->paginate(7);

        // Build query string for sorting.
        $queryString = '?';

        // We need query part with filters without sort to handle sorting
        $queryString .= http_build_query($filter);

        // Query with sort
        $queryStringWithSort = $queryString.'&'.http_build_query(['sort' => $sort, 'order' => $order]);

        //Build url with query string
        $path = 'settings/communities';

        $url = url($path);

        $url .= $queryStringWithSort;

        $list->setPath($url);

        //Store some data in the session for further use
        session([
            'community_list' => $url.'&page='.$list->currentPage(),
        ]);

        //Inverse sort order to make a loop for sorting
        if ($order == 'asc') {
            $order = 'desc';
        } else {
            $order = 'asc';
        }

        return view('admin.communities.index', compact(
            'list',
            'queryString',
            'queryStringWithSort',
            'path',
            'filter',
            'sort',
            'order',
            'countries',
            'regions',
            'cities',
            'types'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (\Gate::denies('create', 'community')) {
            abort(403);
        }

        //Get url of the community list
        if (session('community_list') == null) {
            $urlCommunityList = url('settings/communities');
        } else {
            $urlCommunityList = session('community_list');
        }

        $filter = array(
            'country' => '',
            'region' => '',
            'city' => '',
            'community_type' => ''
            );

        return view('admin.communities.create', [
            'community' => new Community(),
            'filter' => $filter,
            'countries' => Country::all(),
            'community_types' => Type::all(),
            'path' => 'settings/communities',
            'urlCommunityList' => $urlCommunityList,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ValidateCommunityForm $request
     * @return \Illuminate\Http\Response
     */
    public function store(ValidateCommunityForm $request)
    {
        $input = $request->all();

        //Store community data
        Community::create([
            'city_id' => $input['city'],
            'community_type_id' => $input['community_type'],
            'number' => $input['number'],
            'name' => $input['name'],
            ]);

        $message = [
                'flash_message' => \Lang::get('admin/settings.community_created')
            ];

        //Get url of the community list
        if (session('community_list') == null) {
            $urlCommunityList = url('settings/communities');
        } else {
            $urlCommunityList = session('community_list');
        }

        return redirect($urlCommunityList)->with($message);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (\Gate::denies('view', 'community')) {
            abort(403);
        }

        $community = Community::findOrFail($id);
      
        $filter = array(
            'country' => $community->city->region->country->id,
            'region' => $community->city->region->id,
            'city' => $community->city->id,
            'community_type' => $community->community_type_id,
            );

        //Get url of the community list
        if (session('community_list') == null) {
            $urlCommunityList = url('settings/communities');
        } else {
            $urlCommunityList = session('community_list');
        }

        return view('admin.communities.create', [
            'community' => $community,
            'filter' => $filter,
            'countries' => Country::all(),
            'community_types' => Type::all(),
            'path' => 'settings/communities',
            'urlCommunityList' => $urlCommunityList,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (\Gate::denies('update', 'community')) {
            abort(403);
        }

        $community = Community::findOrFail($id);
      
        $filter = array(
            'country' => $community->city->region->country->id,
            'region' => $community->city->region->id,
            'city' => $community->city->id,
            'community_type' => $community->community_type_id,
            );

        //Get url of the community list
        if (session('community_list') == null) {
            $urlCommunityList = url('settings/communities');
        } else {
            $urlCommunityList = session('community_list');
        }

        return view('admin.communities.create', [
            'community' => $community,
            'filter' => $filter,
            'countries' => Country::all(),
            'community_types' => Type::all(),
            'path' => 'settings/communities',
            'urlCommunityList' => $urlCommunityList,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ValidateCommunityForm $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ValidateCommunityForm $request, $id)
    {
        $input = $request->all();

        $community = Community::findOrFail($id);

        $community->update([
            'city_id' => $input['city'],
            'community_type_id' => $input['community_type'],
            'number' => $input['number'],
            'name' => $input['name'],
            ]);

        $message = [
                'flash_message' => \Lang::get('admin/settings.community_updated')
            ];

        //Get url of the community list
        if (session('community_list') == null) {
            $urlCommunityList = url('settings/communities');
        } else {
            $urlCommunityList = session('community_list');
        }

        return redirect($urlCommunityList)->with($message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Get regions list belongs to the country.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getRegions(Request $request)
    {
        $country = $request->input('country');

        return response()->json([
            'regions' => Country::findOrFail($country)->regions()->orderBy('name')->get()
            ]);
    }

    /**
     * Get cities list belongs to the region.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getCities(Request $request)
    {
        $region = $request->input('region');

        return response()->json([
            'cities' => Region::findOrFail($region)->cities()->orderBy('name')->get()
            ]);
    }

    /**
     * Get list for given filter.
     *
     * @param  array $filter
     * @param  string $select
     * @param  bool $order
     *
     * @return Illuminate\Support\Collection
     */
    protected function getFilterList($filter, $select, $order = false)
    {
        //Lists need to be generated for existing communities.
        $query = \DB::table('countries')
        ->join('regions', function ($join) use ($filter) {
            $join->on('countries.id', '=', 'regions.country_id')
                 ->where('regions.country_id', $filter['country']);
        });

        if (!empty($filter['region']) && $select =='cities.*') {
            $query->join('cities', function ($join) use ($filter) {
                $join->on('regions.id', '=', 'cities.region_id')
                     ->where('cities.region_id', $filter['region']);
            });
        } else {
            $query->join('cities', 'regions.id', '=', 'cities.region_id');
        }

        if (!empty($filter['city']) && $select =='communities.community_type_id') {
            $query->join('communities', function ($join) use ($filter) {
                $join->on('cities.id', '=', 'communities.city_id')
                     ->where('communities.city_id', $filter['city']);
            });
        } else {
            $query->join('communities', 'cities.id', '=', 'communities.city_id');
        }

        if (!empty($filter['community_type']) && $select != 'communities.community_type_id') {
            $query->where('communities.community_type_id', $filter['community_type']);
        }

        $query->select($select)->distinct();

        if ($order) {
            $query->orderBy('name');
        }

        return $query->get();
    }
}
