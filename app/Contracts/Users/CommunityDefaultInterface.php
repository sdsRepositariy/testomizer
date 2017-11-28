<?php

namespace App\Contracts\Users;

interface CommunityDefaultInterface
{
 
    /**
     * Store default values for community
     *
     * @return void
    */
    public function storeDefault();

    /**
     * Get default values for community
     *
     * @param Illuminate/Database/Eloquent/Builder $query
     * @return Illuminate/Database/Eloquent/Builder
    */
    public function getDefault($query);
}
