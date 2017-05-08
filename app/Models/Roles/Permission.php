<?php

namespace App\Models\Roles;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    /**------------Model relationships------------*/

    /**
     * The roles that belong to the permissions.
    */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
