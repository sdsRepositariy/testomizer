<?php

namespace App\Models\Communities;

use Illuminate\Database\Eloquent\Model;
use App\Models\Communities\City as City;

class Community extends Model
{
    /**------------Model relationships------------*/
    
    //Get the city associated with the community.
    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
