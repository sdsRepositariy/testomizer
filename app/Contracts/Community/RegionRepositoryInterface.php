<?php

namespace App\Contracts\Community;

interface RegionRepositoryInterface
{
    /**
     * Get all cities belongs to given region.
     *
     * @param int $region
     *
     * @return Illuminate\Database\Eloquent\Collection
    */
    public function getCityByRegion($region);
}
