<?php

namespace App\Http\Controllers\Users\Teachers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Communities\Community as Community;
use App\Models\Roles\Role as Role;
use App\Models\Users\User as User;
use App\Models\Users\UserGroup as Usergroup;
use App\Http\Requests\ValidateTeacherForm as ValidateTeacherForm;

class UserController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (\Gate::denies('create', 'user')) {
            abort(403);
        }

        //Get filters
        $filter['community'] = session('teachers_filter_community');

        if (!isset($filter['community'])) {
            $filter['community'] = \Auth::user()->community_id;
        }

        $filter['role'] = session('teachers_filter_role');

        //Get roles wich can create the user
        $roles = Role::all();
        $authRoles = array();

        foreach ($roles as $role) {
            if (\Gate::allows('create', 'user-'.$role->role)) {
                $authRoles[] = $role;
            }
        }

        //Get url of the user list
        if (session('teachers_user_list') == null) {
            $urlUserList = url('usergroup/teachers', 'list');
        } else {
            $urlUserList = session('teachers_user_list');
        }

        return view('admin.users.teachers.create', [
            'user' => new User(),
            'filter' => $filter,
            'roles' => $authRoles,
            'communities' => Community::all(),
            'path' => 'usergroup/teachers/user',
            'urlUserList' => $urlUserList,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ValidateTeacherForm $request
     * @return \Illuminate\Http\Response
     */
    public function store(ValidateTeacherForm $request)
    {
        $input = $request->all();

        //Complete missed data
        $input['user_group_id'] = Usergroup::where('group', 'teachers')->first()->id;
        $input['login'] = $input['community_id'].'_'.str_slug($input['last_name']).'_'.$input['user_group_id'];
        $input['password'] = str_random(6);

        //Store user data
        $user = User::create($input);

        $message = [
                'flash_message'=> \Lang::get('admin/users.the_user').'&nbsp;'
                .$user->last_name.'&nbsp;'.$user->first_name
                .'&nbsp;'.\Lang::get('admin/users.successfully_created')
            ];

        return back()->with($message);
    }

    /**
     * Display the specified resource.
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function show($user)
    {
        if (\Gate::denies('view', 'user')) {
            abort(403);
        }

        //Get filters
        $filter['community'] = $user->community_id;

        $filter['role'] = $user->role_id;

        $roles = Role::all();

        //Get url of the user list
        if (session('teachers_user_list') == null) {
            $urlUserList = url('usergroup/teachers', 'list');
        } else {
            $urlUserList = session('teachers_user_list');
        }

        return view('admin.users.teachers.create', [
            'user' => $user,
            'filter' => $filter,
            'roles' => $roles,
            'communities' => Community::all(),
            'path' => 'usergroup/teachers/user',
            'urlUserList' => $urlUserList,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit($user)
    {
        if (\Gate::denies('update', 'user-'.$user->role->role)) {
            abort(403);
        }

        //Get filters
        $filter['community'] = $user->community_id;

        $filter['role'] = $user->role_id;

        //Get roles wich can create the user
        $roles = Role::all();
        $authRoles = array();

        foreach ($roles as $role) {
            if (\Gate::allows('create', 'user-'.$role->role)) {
                $authRoles[] = $role;
            }
        }

        //Get url of the user list
        if (session('teachers_user_list') == null) {
            $urlUserList = url('usergroup/teachers', 'list');
        } else {
            $urlUserList = session('teachers_user_list');
        }

        return view('admin.users.teachers.create', [
            'user' => $user,
            'filter' => $filter,
            'roles' => $authRoles,
            'communities' => Community::all(),
            'path' => 'usergroup/teachers/user',
            'urlUserList' => $urlUserList,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(ValidateTeacherForm $request, $user)
    {
        $input = $request->all();
        
        //Update user table
        $user->update($input);

        $message = [
                'flash_message'=> \Lang::get('admin/users.the_user').'&nbsp;'
                .$user->last_name.'&nbsp;'.$user->first_name
                .'&nbsp;'.\Lang::get('admin/users.successfully_updated')
            ];

        //Get url of the user list
        if (session('teachers_user_list') == null) {
            $urlUserList = url('usergroup/teachers', 'list');
        } else {
            $urlUserList = session('teachers_user_list');
        }

        return redirect($urlUserList)->with($message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($user)
    {
        if (\Gate::denies('delete', 'user-'.$user->role->role)) {
            abort(403);
        }

        $user->delete();

        $message = [
            'flash_message'=> \Lang::get('admin/users.the_user').'&nbsp;'
                .$user->last_name.'&nbsp;'.$user->first_name
                .'&nbsp;'.\Lang::get('admin/users.successfully_removed')
        ];

        return back()->with($message);
    }

    /**
     * Generate new password for the user.
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
    */
    public function changePassword($user)
    {
        if (\Gate::denies('update', 'user-'.$user->role->role)) {
            abort(403);
        }

        $user->password = str_random(6);

        $user->save();

        $message = [
                'flash_message'=> \Lang::get('admin/users.new_password').'&nbsp;'
                .$user->password.'&nbsp;'.\Lang::get('admin/users.successfully_created')
            ];

        return back()->with($message);
    }
}
