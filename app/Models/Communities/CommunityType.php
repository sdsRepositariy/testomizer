<?php

namespace App\Models\Communities;

use Illuminate\Database\Eloquent\Model;
use App\Models\Communities\Community as Community;

class CommunityType extends Model
{
    /**------------Model relationships------------*/

    /**
     * Get communiteis for the community type
    */
    public function community()
    {
        return $this->hasMany(Community::class);
    }
}
