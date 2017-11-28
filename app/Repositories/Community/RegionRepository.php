<?php

namespace App\Repositories\Community;

use App\Contracts\Community\RegionRepositoryInterface as RegionRepoInterface;
use App\Repositories\AbstractRepository as AbstractRepository;
use App\Models\Communities\Region as Region;

class RegionRepository extends AbstractRepository implements RegionRepoInterface
{
    /**
     * The region model.
     *
     * @var Illuminate\Database\Eloquent\Model
     */
    protected $model;

    /**
     * Create a new repositoriy instance.
     *
     * @return void
     */
    public function __construct(Region $region)
    {
        $this->model = $region;
    }

    /**
     * Get all cities belongs to given region.
     *
     * @param int $region
     *
     * @return Illuminate\Database\Eloquent\Collection
    */
    public function getCityByRegion($region)
    {
        return $this->getById($region)->cities;
    }
}
