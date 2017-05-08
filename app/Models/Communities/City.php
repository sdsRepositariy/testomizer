<?php

namespace App\Models\Communities;

use App\Models\Communities\Region as Region;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    /**------------Model relationships------------*/
    
    //Get the region associated with the city.
    public function region()
    {
        return $this->belongsTo(Region::class);
    }
}
