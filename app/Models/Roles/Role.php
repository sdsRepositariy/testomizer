<?php

namespace App\Models\Roles;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * Get children roles for given role.
     *
     * @param  int  $id
     * @return array
    */
    public function getChildren($parent)
    {
        $roles = Role::all();

        //Get child role
        $role = $roles->find($parent)->childRole;

        //Get id array of children
        $children = array();

        while (is_object($role)) {
            $children [] = $role->id;
            $role = $role->childRole;
        }

        return $children;
    }

    /**------------Model relationships------------*/

    /**
     * The permissions that belong to the role.
    */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
}
