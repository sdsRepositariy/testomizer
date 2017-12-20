<?php

namespace App\Models\Communities;

use Illuminate\Database\Eloquent\Model;
use App\Models\Communities\City as City;
use App\Models\Communities\CommunityType as CommunityType;
use App\Models\Users\Grade as Grade;
use App\Models\Users\Stream as Stream;
use App\Models\Users\Level as Level;
use App\Models\Users\Period as Period;
use App\Models\Users\User as User;

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

    //Get grades associated with the community.
    public function grades()
    {
        return $this->hasMany(Grade::class);
    }

    //Get streams associated with the community.
    public function streams()
    {
        return $this->belongsToMany(Stream::class, 'grades');
    }

    //Get levels associated with the community.
    public function levels()
    {
        return $this->belongsToMany(Level::class, 'grades');
    }

    //Get periods associated with the community.
    public function periods()
    {
        return $this->belongsToMany(Period::class, 'grades');
    }

    //Get the users for the community.
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
