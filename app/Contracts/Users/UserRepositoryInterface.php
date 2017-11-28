<?php

namespace App\Contracts\Users;

interface UserRepositoryInterface
{
    /**
     * Get authenticated user.
     *
     * @return Illuminate\Database\Eloquent\Collection
    */
    public function getAuthUser();
}
