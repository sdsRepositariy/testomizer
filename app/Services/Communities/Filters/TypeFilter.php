<?php

namespace App\Services\Communities\Filters;

use App\Contracts\Common\FilterInterface as FilterInterface;
use App\Contracts\Community\CommunityTypeRepositoryInterface as CommunityTypeRepo;

class TypeFilter implements FilterInterface
{
    /**
     * The CommunityType implementation
     *
     * @var CommunityType
    */
    protected $communityType;

    /**
     * Create a new community type filter instance.
     *
     * @return void
     */
    public function __construct(CommunityTypeRepo $communityType)
    {
        $this->communityType = $communityType;
    }

    /**
     * The query filter
     *
     * @param string $attribute
     *
     * @return array
    */
    public function apply($attribute)
    {
        //The default or given values for filters stored in the session
        //so empty community array in the session means the first filter call.
        if (session('community_type') == null) {
            $this->storeDefault();
        }

        //Get default attribute if filter is not active
        if (!isset($attribute)) {
            $attribute = session('community_type.type_selected');
        }

        //Apply type filter
        if ($attribute == 'all') {
            session(['community.type_selected' => $attribute]);
            return $query->whereIn('community_type_id', CommunityType::all()->pluck('id'));
        } else {
            //Get community type instance
            $type = CommunityType::findOrFail($attribute);
            dd($query);
            //Store data in the session
            session(['community.type_selected' => $attribute]);
          
            return $query->whereIn('community_type_id', [$type->id]);
        }
    }

    /**
     * Store default values in the session
     *
     * @return void
    */
    protected function storeDefault()
    {
        //The default community type - community type of the authenticated user.
        $authUserId = $this->user->getAuthUser()->id;
        $authUserInst = $this->user->getByIdWith($authUserId, ['community.communityType']);

        //Store default values in the session
        session([
            'community_type.type_selected' => $authUserInst->community->communityType->id,
        ]);
    }
}
