<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

class Respondent extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'first_name', 'middle_name', 'last_name', 'phone_number', 'reference', 'email',
    ];

    /**------------Model Relations------------
     *
     * Get respondent's data as user.
     */
    public function member()
    {
        return $this->morphOne(User::class, 'owner');
    }
}
