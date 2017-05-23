<?php

namespace App\Models\Users;

use App\Models\Roles\Role as Role;
use App\Models\Communities\Community as Community;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable;

    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['community_id', 'role_id', 'first_name', 'middle_name', 'last_name', 'login', 'password', 'birthday', 'email', 'phone_number', 'user_group_id', 'user_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Check if given role is Superadmin.
     * The superadmin role has not parents
     * so we will check if the role has a parent
     *
     * @return bool
    */
    public function isSuperadmin()
    {
        return $this->role->role_id === null;
    }

   
    /**------------Model relationships------------*/
    
    
    //Get the role associated with the user.
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Get the user group that owns the user.
     */
    public function userGroup()
    {
        return $this->belongsTo(UserGroup::class);
    }

    //Get the community associated with the user.
    public function community()
    {
        return $this->belongsTo(Community::class);
    }

    //Get the grade associated with the user.
    public function grades()
    {
        return $this->belongsToMany(Grade::class);
    }

    /**
     * Get the parent of a student.
     */
    public function parent()
    {
        return $this->hasOne(__CLASS__);
    }
}
