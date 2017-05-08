<?php

namespace App\Services\Users\Filters;

use App\Contracts\Users\FilterInterface as FilterInterface;
use App\Models\Roles\Role as Role;

class RoleFilter implements FilterInterface
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

        //Get stored filter data or default value
        if (!$filter) {
            $attribute = session(''.$userGroup.'.role', $this->defaultValue);
        }
      
        if ($attribute == 'all') {
            session([''.$userGroup.'.role' => $attribute]);
            return $query;
        } else {
            $roleId = Role::where('role', $attribute)
                ->firstOrFail()
                ->id;

            session([''.$userGroup.'.role' => $attribute]);
            return $query->where('role_id', $roleId);
        }
    }
}
