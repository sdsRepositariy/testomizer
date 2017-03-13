<?php

namespace App\Policies;

use App\Models\Users\User as User;
use App\Models\Users\Admin as Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminPolicy
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
     * Determine rights for superadmin.
     *
     * @param  App\Models\Users\User  $user
     * @param  $ability
     * @return bool
    */
    public function before($user, $ability)
    {
        if ($user->role->role === 'superadmin') {
            return true;
        }
    }

    /**
     * Determine if the given user can view users list.
     *
     * @param  App\Models\Users\User  $user
     * @return bool
    */
    public function getList(User $user)
    {
        return false;
    }

    /**
     * Determine if the given user can view the others.
     *
     * @param  App\Models\Users\User  $user
     * @param  App\Models\Users\Admin  $admin
     * @return bool
    */
    public function view(User $user, Admin $admin)
    {
        return $user->owner->id === $admin->id;
    }

    /**
     * Determine if the given user can create.
     *
     * @param  App\Models\Users\User  $user
     * @return bool
    */
    public function create(User $user)
    {
        return false;
    }

    /**
     * Determine if the given user can update the others.
     *
     * @param  App\Models\Users\User  $user
     * @param  App\Models\Users\Admin  $admin
     * @return bool
    */
    public function update(User $user, Admin $admin)
    {
        return $user->owner->id === $admin->id;
    }

    /**
     * Determine if the given user can delete.
     *
     * @param  App\Models\Users\User  $user
     * @return bool
    */
    public function delete(User $user)
    {
        return false;
    }
}
