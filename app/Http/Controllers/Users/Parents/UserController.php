<?php

namespace App\Http\Controllers\Users\Parents;

use App\Models\Roles\Role as Role;
use App\Models\Users\User as User;
use App\Models\Communities\Community as Community;
use App\Models\Users\UserGroup as Usergroup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ValidateParentForm as ValidateParentForm;

class UserController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @param  User $student
     * @return \Illuminate\Http\Response
     */
    public function create($student)
    {
        if (\Gate::denies('view', 'user-respondent')) {
            abort(403);
        }

        //Get url of the parent list
        if (session('parents_user_list') == null) {
            $urlUserList = url('usergroup/parents', 'list');
        } else {
            $urlUserList = session('parents_user_list');
        }

        return view('admin.users.parents.create', [
            'user' => new User(),
            'student' => $student,
            'path' => 'usergroup/parents/user',
            'urlUserList' => $urlUserList,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ValidateParentForm $request
     * @return \Illuminate\Http\Response
     */
    public function store(ValidateParentForm $request)
    {
        $input = $request->all();

        //Complete missed data
        $input['user_group_id'] = Usergroup::where('group', 'parents')->first()->id;
        $input['login'] = $input['community_id'].'_'.str_slug($input['last_name']).'_'.$input['user_group_id'];
        $input['password'] = str_random(6);
        $input['role_id'] = Role::where('role', 'respondent')->first()->id;

        //Store user data
        $student = User::find($input['student_id']);
        $user = $student->parent()->create($input);

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
        if (\Gate::denies('view', 'user-respondent')) {
            abort(403);
        }

        //Get url of the parent list
        if (session('parents_user_list') == null) {
            $urlUserList = url('usergroup/parents', 'list');
        } else {
            $urlUserList = session('parents_user_list');
        }

        return view('admin.users.parents.create', [
            'user' => $user,
            'student' => $user->student,
            'path' => 'usergroup/parents/user',
            'urlUserList' => $urlUserList,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function edit($user)
    {
        if (\Gate::denies('view', 'user-respondent')) {
            abort(403);
        }

        //Get url of the parent list
        if (session('parents_user_list') == null) {
            $urlUserList = url('usergroup/parents', 'list');
        } else {
            $urlUserList = session('parents_user_list');
        }

        return view('admin.users.parents.create', [
            'user' => $user,
            'student' => $user->student,
            'path' => 'usergroup/parents/user',
            'urlUserList' => $urlUserList,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ValidateParentForm $request
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function update(ValidateParentForm $request, $user)
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
        if (session('parents_user_list') == null) {
            $urlUserList = url('usergroup/parents', 'list');
        } else {
            $urlUserList = session('parents_user_list');
        }

        return redirect($urlUserList)->with($message);
    }

    /**
     * Generate new password for the user.
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
    */
    public function changePassword($user)
    {
        if (\Gate::denies('create', 'user-respondent')) {
            return false;
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
