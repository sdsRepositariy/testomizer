<?php

namespace App\Http\Controllers\Communities;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class CommunityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
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

        // $list = $this->communities->getCommunityList($queryParameters);
        dd($queryString);
        //Apply filters
        // $list = $getFilter->filter($query, $queryString, $this->filterable, 'App\Services\Communities\Filters')->paginate(5);
        // dd(\Request::session()->all());
        // return view('admin.communities.index', [
        //     'list' => $list,
        //     'slug' => 'settings/communities',
        //     'countries' => Country::all(),
        //     'regions' => Region::all(),
        //     'cities' => City::all(),
        //     'types' => Type::all(),
        //     'session' => \Session::get($userGroup->group),
        // ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
}
