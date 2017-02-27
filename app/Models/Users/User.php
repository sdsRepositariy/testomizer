<?php

namespace App\Models\Users;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'middle_name', 'last_name', 'phone_number', 'city', 'country', 'school_number', 'email',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    //Get user role
    public function hasRole($role)
    {
        return $this->roles->contains('role', $role);
    }

    //Model Relations
    public function roles()
    {
        return $this->belongsToMany('App\Models\Users\Role');
    }
}
