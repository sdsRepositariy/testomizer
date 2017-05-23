<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;
use App\Models\Users\Grade as Grade;
use Carbon\Carbon;

class Period extends Model
{
    /**
     * Get academic year.
     *
     * @return string
    */
    public function period()
    {
        return Carbon::parse($this->year_start)
            ->year."-".Carbon::parse($this->year_end)->year;
    }
    
    /**------------Model relationships------------*/

    /**
     * The periods that belong to the grade.
    */
    public function grades()
    {
        return $this->hasMany(Grade::class);
    }
}
