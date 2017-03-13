<?php

namespace App\Models\Users;

use App\Models\Users\Role as Role;
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
    protected $fillable = ['owner_id', 'owner_type', 'role_id', 'login', 'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**------------Model Relations------------*/
    
    //Get all owners of the user models.
    public function owner()
    {
        return $this->morphTo()->withTrashed();
    }

    //Get the role associated with the user.
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
