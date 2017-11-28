<?php

namespace App\Models\Communities;

use Illuminate\Database\Eloquent\Model;
use App\Models\Communities\Region as Region;
use App\Models\Communities\Cities as Cities;

class Country extends Model
{
    /**------------Model relationships------------*/

    /**
     * Get regions for the country
    */
    public function regions()
    {
        return $this->hasMany(Region::class);
    }

    /**
     * Get all of the cities for the country.
    */
    public function cities()
    {
        return $this->hasManyThrough(City::class, Region::class);
    }
}
