<?php

namespace App\Contracts\Community;

interface CommunityRepositoryInterface
{
    /**
     * Make community list
     *
     * @param array $queryParameters
     *
     * @return \Illuminate\Database\Eloquent\Collection
     *
    */
    public function getCommunityList($queryParameters);
}
