<?php

namespace App\Models\Communities;

use App\Models\Communities\Region as Region;
use App\Models\Communities\Community as Community;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    /**------------Model relationships------------*/
    
    //Get the region associated with the city.
    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    /**
     * Get communities for the city
    */
    public function communities()
    {
        return $this->hasMany(Community::class);
    }
}
