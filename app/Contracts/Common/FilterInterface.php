<?php

namespace App\Contracts\Common;

interface FilterInterface
{
 
    /**
     * Prepare query filter
     *
     * @param string $attribute
     *
     * @return array
    */
    public function apply($attribute);
}
