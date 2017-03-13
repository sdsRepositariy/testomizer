<?php

namespace App\Http\Controllers\Users;

use App\Models\Users\Admin as Admin;
use App\Models\Users\Role as Role;
use App\Models\Users\User as User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ValidateAdmin as ValidateAdmin;
use App\Traits\CreateCredentials;

class AdminController extends Controller
{
    /*
    |The controller uses a trait
    |to generate login and password.
    |
    */

    use CreateCredentials;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = \Auth::user();
        if ($user->can('getList', Admin::class)) {
            $list = Admin::withTrashed()->orderBy('last_name', 'asc')->paginate(5);
            return view('admins.admin.index', ['list' => $list]);
        } else {
            return redirect('/home');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (\Auth::user()->can('create', Admin::class)) {
            return view('admins.admin.create', ['admin' => new Admin()]);
        } else {
            return redirect()->back();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\ValidateAdmin $request
     * @return \Illuminate\Http\Response
     */
    public function store(ValidateAdmin $request)
    {
        if (\Auth::user()->can('create', Admin::class)) {
            $input = $request->all();
            $admin = Admin::create($input);

            /**--Store admin credentials in User model--*/
        
            //Create unique login
            while (true) {
                //createLogin(int $letterQty, int $digitQty)
                $login = $this->createLogin(1, 5);
                if (!User::withTrashed()->get()->contains('login', $login)) {
                    break;
                }
            }

            //Store
            //createPassword(int $passLenght)
            $password = $this->createPassword(2);
            $newUser = new User([
                'role_id' => Role::where('role', '=', 'admin')->value('id'),
                'login' => $login,
                'password' => bcrypt($password),
            ]);

            $admin->member()->save($newUser);

            $message = [
                'flash_message'=>'The user'.'&nbsp;'
                .$admin->first_name.'&nbsp;'.$admin->last_name
                .'&nbsp;'.'successfully created'.'&nbsp;'
                .'password '.$password
            ];
        
            return redirect('/admin')->with($message);
        } else {
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
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
