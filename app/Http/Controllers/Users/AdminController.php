<?php

namespace App\Http\Controllers\Users;

use App\Models\Users\Admin as Admin;
use App\Models\Users\Role as Role;
use App\Models\Users\User as User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ValidateUser as ValidateUser;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $list = Admin::orderBy('last_name')->paginate(10);
        return view('admins.admin.index', ['list' => $list]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       return view('admins.admin.create', ['admin' => new Admin()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\ValidateUser $request
     * @return \Illuminate\Http\Response
     */
    public function store(ValidateUser $request)
    {
        //Store new user
        // $user = User::create([
        //     'first_name'=>$request->input('first_name'),
        //     'middle_name'=>$request->input('middle_name'),
        //     'last_name'=>$request->input('last_name'),
        //     'email'=>$request->input('email'),
        //     'phone_number'=>$request->input('phone_number'),
        //     'country'=>$request->input('country'),
        //     'city'=>$request->input('city'),
        //     'school_number'=>$request->input('school_number'),
        //     'password'=>bcrypt($request->input('password'))
        // ]);

        // //Store user role
        // $user->roles()->attach($request->input('role_id'));

        // return redirect('/users')->with(['flash_message'=>'The user'.'&nbsp;'.$user->first_name.'&nbsp;'.$user->middle_name.'&nbsp;'.$user->last_name.'&nbsp;'.'successfully created']);
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