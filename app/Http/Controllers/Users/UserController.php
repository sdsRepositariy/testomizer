<?php

namespace App\Http\Controllers\Users;

use App\Models\Roles\Role as Role;
use App\Models\Users\User as User;
use App\Models\Communities\Community as Community;
use App\Models\Users\Level as Level;
use App\Models\Users\Stream as Stream;
use App\Models\Users\UserGroup as Usergroup;
use App\Models\Users\Period as Period;
use App\Models\Users\Grade as Grade;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ValidateAdmin as ValidateAdmin;
use App\Traits\CreateCredentials;

class UserController extends Controller
{
    /*
    |The controller uses a trait
    |to generate login and password.
    |
    */

    use CreateCredentials;

    /**
     * The usergroup
     *
     * @var string
    */
    protected $usergroup;

    /**
     * Create a new controller instance.
     *
     * @param App\Models\Users\UserGroup $usergroup
     * @return void
    */
    public function __construct(Usergroup $usergroup)
    {
        $this->usergroup = $usergroup;
    }

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

        //Get roles which correspondents to the user permissions
        $roles = array();
        foreach (Role::all() as $role) {
            if (\Gate::allows('create', 'user-'.$role->role)) {
                $roles[$role->id] = $role->role;
            }
        };
       
        //Get community
        if (\Gate::allows('create', 'community')) {
            $communities = Community::all();
        } else {
            $communities = Community::findOrFail(\Auth::user()->community_id);
        }

        //Get student instance
        $student = '';
        if ($this->usergroup->group == 'parents') {
            $student = User::findOrFail(\Request::input('student'));
        }

        return view('admin.users.create', [
            'user' => new User(),
            'communities' => $communities,
            'roles' => $roles,
            'levels' => Level::all(),
            'streams' => Stream::all(),
            'student' => $student,
            'periods' => Period::all(),
            'usergroup' => $this->usergroup,
            'slug' => 'usergroup/'.$this->usergroup->group.'/user',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\ValidateAdmin $request
     * @return \Illuminate\Http\Response
     */
    public function store(ValidateAdmin $request)
    {
        $input = $request->all();
     
        //Add usergroup Id
        $input['user_group_id'] = $this->usergroup->id;

        //Add community
        if (\Gate::denies('create', 'community')) {
            $input['community_id'] = \Auth::user()->community_id;
        }

        //Create and add a login
        while (true) {
            //createLogin(int $letterQty, int $digitQty)
            $login = $this->createLogin(1, 5);
            if (!User::withTrashed()->get()->contains('login', $login)) {
                break;
            }
        }
        $input['login'] = $login;

        //Create and add a password createPassword(int $passLenght)
        $input['password'] = $this->createPassword(2);
       
        //Store user data
        $user = User::create($input);
       
        if (\Route::input('usergroup')->group == 'students') {
            //Get student grade
            $grade = Grade::where([
                ['level_id', '=', $input['level_id']],
                ['period_id', '=', $input['period_id']],
                ['stream_id', '=', $input['stream_id']],
            ])->first();
          
            //If grade doesnt exist then create missed grade
            if ($grade == null) {
                $grade = Grade::create($input);
            }
            
            //Iinsert the record to the intermediate table.
            $user->grades()->attach($grade->id);
        }

        //Return the view with the message
        $message = [
                'flash_message'=>'The user'.'&nbsp;'
                .$user->first_name.'&nbsp;'.$user->last_name
                .'&nbsp;'.'successfully created'.'&nbsp;'
                .'password '.$user->password
            ];
        
        return redirect('/usergroup/'.$this->usergroup->group.'/user')->with($message);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $id2)
    {
        $this->authorize('view', $id2);
        dd(\Route::current()->getName());
        $user = \Auth::user();
        $admin = Admin::findOrFail($id);
        if ($user->cant('view', $admin)) {
            return redirect()->back();
        } else {
            return view('admins.admin.create', ['admin' => $admin]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        dd('edit');
        $user = \Auth::user();
        $admin = Admin::findOrFail($id);
        if ($user->cant('update', $admin)) {
            return redirect()->back();
        } else {
            return view('admins.admin.create', ['admin' => $admin]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\ValidateAdmin $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ValidateAdmin $request, $id)
    {
        dd('update');
        $user = \Auth::user();
        $admin = Admin::findOrFail($id);
        if ($user->cant('update', $admin)) {
            return redirect()->back();
        } else {
            $input = $request->all();
            $admin->update($input);

            $message = [
                'flash_message'=>'The user'.'&nbsp;'.$admin->first_name
                .'&nbsp;'.$admin->last_name.'&nbsp;'.'successfully updated'
            ];

            return redirect('/admin')->with($message);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        dd('destroy');
        if (\Auth::user()->can('delete', Admin::class)) {
            $admin = Admin::findOrFail($id);

            //Delete records
            $admin->delete();
            $admin->member()->delete();

            $message = [
                'flash_message'=>'The user'.'&nbsp;'.$admin->first_name
                .'&nbsp;'.$admin->last_name.'&nbsp;'.'successfully disabled'
            ];

            return redirect()->back()->with($message);
        } else {
            return redirect()->back();
        }
    }
}
