<?php

namespace App\Models\Communities;

use Illuminate\Database\Eloquent\Model;
use App\Models\Communities\City as City;
use App\Models\Communities\Country as Country;

class Region extends Model
{
    /**------------Model relationships------------*/

    /**
     * Get cities for the region
    */
    public function cities()
    {
        return $this->hasMany(City::class);
    }

    /**
     * Get the country associated with the region.
    */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
