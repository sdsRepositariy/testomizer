<?php

namespace App\Services\Users\Filters;

use App\Contracts\Users\FilterInterface as FilterInterface;
use App\Models\Users\Period as Period;
use Carbon\Carbon;

class PeriodFilter implements FilterInterface
{
    /**
     * The deffault value for filter
     *
     * @var string
    */
    protected $defaultValue;

    /**
     * Create a new filter instance.
     *
     * @return void
    */
    public function __construct()
    {
        $currentDate = Carbon::now()->toDateString();
        
        //Get current academic year as default
        $currentPeriod = Period::where([
            ['year_start', '<=', $currentDate],
            ['year_end', '>=', $currentDate],
        ])->first();
          
        $this->defaultValue = Carbon::parse($currentPeriod->year_start)
            ->year."-".Carbon::parse($currentPeriod->year_end)->year;
    }

    /**
     * The query filter
     *
     * @param Illuminate/Database/Eloquent/Builder $query
     * @param bool $filter
     * @param string $attribute
     *
     * @return Illuminate/Database/Eloquent/Builder
    */
    public function filter($query, $filter, $attribute)
    {
        $userGroup = \Route::input('usergroup')->group;

        //The filter works for groups students or parents only
        if ($userGroup == 'teachers') {
            return $query;
        }
      
        if (!$filter) {
            //Get stored filter data or default value
            $attribute = session(''.$userGroup.'.period', $this->defaultValue);
        }
        
        //Get period start and end
        $yearStart = strstr($attribute, "-", true);
        $yearEnd = substr($attribute, strpos($attribute, '-')+1);
       
        //Get Period instance
        $period = Period::where([
            ['year_start', 'like', $yearStart.'%'],
            ['year_end', 'like', $yearEnd.'%'],
        ])->firstOrFail();
        

        //Store data in the session
        session([''.$userGroup.'.period' => Carbon::parse($period->year_start)->year.'-'.Carbon::parse($period->year_end)->year]);

        //Get users ID
        $userId = array();

        //Load grades for given period
        $grades = $period->grades->all();

        foreach ($grades as $grade) {
            //Load users for given grade
            $users = $grade->users->all();
            
            foreach ($users as $user) {
                $userId[] = $user->id;
            }
        }
 
        return $query->whereIn('id', $userId);
    }
}
