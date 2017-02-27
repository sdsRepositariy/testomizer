<?php

namespace App\Policies;

use App\Models\Users\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
    * Determine if the given user can see users list.
    *
    * @param  \App\User  $user
    * @return bool
    */
    public function index(User $user)
    {
        //
    }

    
    /**
    * Determine if the given user can create new user.
    *
    * @param  \App\User  $user
    * @return bool
    */
    public function create(User $user)
    {
        //
    }

    /**
    * Determine if the given user can delete another user.
    *
    * @param  \App\User  $user
    * @return bool
    */
    public function destroy(User $user)
    {
        //
    }

}
