<?php

namespace App\Services\Users\Filters;

use App\Contracts\Users\FilterInterface as FilterInterface;
use App\Models\Users\Level as Level;

class LevelFilter implements FilterInterface
{
    /**
     * The deffault value for filter
     *
     * @var string
    */
    protected $defaultValue = 'all';

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

        //Get stored filter data or default value
        if (!$filter) {
            $attribute = session(''.$userGroup.'.level', $this->defaultValue);
        }

        if ($attribute == 'all') {
            session([''.$userGroup.'.level' => $attribute]);
            return $query;
        } else {
            //Get level instance
            $level = Level::where('number', $attribute)
                ->firstOrFail();

            //Store data in the session
            session([''.$userGroup.'.level' => $level->number]);

            //Get users ID
            $userId = array();
            foreach ($level->grades as $grade) {
                foreach ($grade->users as $user) {
                    $userId[] = $user->id;
                }
            }
          
            return $query->whereIn('id', $userId);
        }
    }
}
