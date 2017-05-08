<?php

namespace App\Contracts\Users;

interface FilterInterface
{
 
    /**
     * Prepare query filter
     *
     * @param Illuminate/Database/Eloquent/Builder $query
     * @param bool $filter
     * @param string $attribute
     *
     * @return Illuminate/Database/Eloquent/Builder
    */
    public function filter($query, $filter, $attribute);
}
