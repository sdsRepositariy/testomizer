<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;
use App\Models\Users\Grade as Grade;
use Carbon\Carbon;

class Period extends Model
{   
    /**
     * The first day of academic year.
    */
    protected $startDay = 1;

    /**
     * The first month of academic year.
    */
    protected $startMonth = 9;

    /**
     * Get academic year.
     *
     * @return string
    */
    public function getCurrentPeriodId()
    {
        $now = Carbon::now('Europe/Kiev');

        if ($now->month < $this->startMonth) {
            $startYear = $now->year - 1;
        } else {
            $startYear = $now->year;
        }
        
        return \DB::table('periods')->where('year_start', '=', Carbon::createFromDate($startYear, $this->startMonth, $this->startDay, 'Europe/Kiev')->toDateString())->value('id');
    }

    /**
     * Extract from date year only.
     *
     * @return string
    */
    public function getPeriod()
    {
        $date_start = Carbon::parse($this->year_start);
        $date_end = Carbon::parse($this->year_end);
        return $date_start->year."-".$date_end->year;
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
