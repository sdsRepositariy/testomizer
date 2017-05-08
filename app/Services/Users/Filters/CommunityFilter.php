<?php

namespace App\Services\Users\Filters;

use App\Contracts\Users\FilterInterface as FilterInterface;
use App\Models\Communities\Community as Community;

class CommunityFilter implements FilterInterface
{
    /**
     * The deffault value for filter
     *
     * @var string
    */
    protected $defaultValue = 'my_community';

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
            $attribute = session(''.$userGroup.'.community', $this->defaultValue);
        }
        
        if (!\Gate::allows('create', 'community')) {
            $attribute = 'my_community';
        }

        switch ($attribute) {
            case 'all':
                session([''.$userGroup.'.community' => $attribute]);
                return $query;
            case 'my_community':
                $communityId = \Auth::user()->community_id;
                session([''.$userGroup.'.community' => $attribute]);
                return $query->where('community_id', $communityId);
            default:
                $communityId = Community::findOrFail($attribute)->id;
                session([''.$userGroup.'.community' => $attribute]);
                return $query->where('community_id', $communityId);
        }
    }
}
