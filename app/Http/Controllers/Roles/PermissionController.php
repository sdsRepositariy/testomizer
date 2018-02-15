<?php

namespace App\Http\Controllers\Roles;

use App\Models\Roles\Role as Role;
use App\Models\Roles\Object as Object;
use App\Models\Roles\Permission as Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($role)
    {
        if (\Gate::denies('view', 'permissions')) {
            abort(403);
        }

        $roles = Role::all();

        $permissions = Permission::all();

        $objects = Object::all();
       
        return view('admin.roles.index', [
            'roles' => $roles,
            'permissions' => $permissions,
            'currentRole' =>$role,
            'objects' => $objects,
        ]);
    }

    /**
     * Save assigned permissions.
     *
     * @param  App\Http\Requests $request
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request, $role)
    {
        if (\Gate::denies('create', 'permissions')) {
            abort(403);
        }
              
        //Clear intermedia table
        $role->permissions()->detach();

        foreach ($request->except('_token') as $key => $value) {
            //Retrive input
            $pos = strpos($key, '-');
            $objectId = intval(substr($key, 0, $pos));
            $permissionId = intval($value);
         
            //Save role - permission assignment
            $role->permissions()->attach($permissionId, ['object_id' => $objectId]);
        }
        
        $message = ['flash_message'=>'The role permissions were successfully updated'];

        return redirect()->back()->with($message);
    }
}
