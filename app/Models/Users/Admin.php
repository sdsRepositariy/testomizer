<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Admin extends Model
{
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
    protected $fillable = [
        'first_name', 'middle_name', 'last_name', 'phone_number', 'city', 'country', 'school_number', 'email',
    ];

    /**------------Model Relations------------
     *
     * Get admin's data as user.
     */
    public function member()
    {
        return $this->morphOne(User::class, 'owner');
    }
}
