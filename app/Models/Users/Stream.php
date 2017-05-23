<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;
use App\Models\Users\Grade as Grade;

class Stream extends Model
{
    /**------------Model relationships------------*/

    /**
     * The streams that belong to the grade.
    */
    public function grades()
    {
        return $this->hasMany(Grade::class);
    }
}
