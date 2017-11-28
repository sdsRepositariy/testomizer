<?php

namespace App\Contracts\Users;

interface FilterInterface
{
    /**
     * The query filter
     *
     * @param Illuminate/Database/Eloquent/Builder $query
     * @param bool $filter
     * @param string $attribute
     *
     * @return Illuminate/Database/Eloquent/Builder
    */
    public function apply($query, $filter, $attribute);
}
