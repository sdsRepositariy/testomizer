<?php

namespace App\Models\Communities;

use Illuminate\Database\Eloquent\Model;
use App\Models\Communities\City as City;
use App\Models\Communities\CommunityType as CommunityType;

class Community extends Model
{
    /**------------Model relationships------------*/
    
    //Get the city associated with the community.
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    //Get the community type associated with the community.
    public function communityType()
    {
        return $this->belongsTo(CommunityType::class);
    }
}
