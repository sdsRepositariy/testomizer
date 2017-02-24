<?php

namespace App\Http\Controllers\Admin;

use App\Models\Users\User as User;
use App\Models\Users\Role as Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ValidateUser as ValidateUser;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list = User::paginate(10);
        return view('admin.users.index', ['list' => $list]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       return view('admin.users.create', ['user' => new User(), 'roles' => Role::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\ValidateUser $request
     * @return \Illuminate\Http\Response
     */
    public function store(ValidateUser $request)
    {
        $user = User::create([
            'first_name'=>$request->get('first_name'),
            'middle_name'=>$request->get('middle_name'),
            'last_name'=>$request->get('last_name'),
            'email'=>$request->get('email'),
            'phone_number'=>$request->get('phone_number'),
            'country'=>$request->get('country'),
            'city'=>$request->get('city'),
            'school_number'=>$request->get('school_number'),
            'password'=>bcrypt($request->get('password'))
        ]);

        $user->roles()->attach($request->get('role_id'));

        return redirect('/users')->with(['flash_message'=>'The user'.'&nbsp;'.$user->first_name.'&nbsp;'.$user->middle_name.'&nbsp;'.$user->last_name.'&nbsp;'.'successfully created']);
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
