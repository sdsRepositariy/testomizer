<?php

namespace App\Contracts\Community;

interface CommunityTypeRepositoryInterface
{
    /**
     * Get region belongs to given city.
     *
     * @param int $city
     *
     * @return Illuminate\Database\Eloquent\Collection
    */
    public function getRegionByCity($city);

    /**
     * Get country belongs to given city.
     *
     * @param int $city
     *
     * @return Illuminate\Database\Eloquent\Collection
    */
    public function getCountryByCity($city);
}
