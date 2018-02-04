<?php

namespace App\Models\Roles;

use Illuminate\Database\Eloquent\Model;
use App\Models\Roles\Role as Role;

class Role extends Model
{
    /**------------Model relationships------------*/

    /**
     * The permissions that belong to the role.
    */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
}
