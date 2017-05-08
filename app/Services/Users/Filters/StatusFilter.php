<?php

namespace App\Services\Users\Filters;

use App\Contracts\Users\FilterInterface as FilterInterface;

class StatusFilter implements FilterInterface
{
    /**
     * The deffault value for filter
     *
     * @var string
    */
    protected $defaultValue = 'active';

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

        //Get stored filter data or default value
        if (!$filter) {
            $attribute = session(''.$userGroup.'.status', $this->defaultValue);
        }

        switch ($attribute) {
            case 'all':
                session([''.$userGroup.'.status' => $attribute]);
                return $query->withTrashed();
            case 'active':
                session([''.$userGroup.'.status' => $attribute]);
                return $query;
            case 'deleted':
                session([''.$userGroup.'.status' => $attribute]);
                return $query->onlyTrashed();
            default:
                abort(404);
        }
    }
}
