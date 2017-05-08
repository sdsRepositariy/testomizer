<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

class UserGroup extends Model
{
    /**------------Model relationships------------*/
    
    /**
    * Get the users for the user group.
    */
    public function users()
    {
        return $this->hasMany(User::class)->withTrashed();
    }
}
