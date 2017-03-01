<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;


class Admin extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'middle_name', 'last_name', 'phone_number', 'city', 'country', 'school_number', 'email',
    ];

    /**------------Model Relations------------
     *
     * Get admin's data as user.
     */
    public function member()
    {
        return $this->morphOne('App\Models\Users\User', 'owner');
    }
}
