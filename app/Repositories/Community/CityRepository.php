<?php

namespace App\Repositories\Community;

use App\Contracts\Community\CityRepositoryInterface as CityRepoInterface;
use App\Repositories\AbstractRepository as AbstractRepository;
use App\Models\Communities\City as City;

class CityRepository extends AbstractRepository implements CityRepoInterface
{
    /**
     * The city model.
     *
     * @var Illuminate\Database\Eloquent\Model
     */
    protected $model;

    /**
     * Create a new repositoriy instance.
     *
     * @return void
     */
    public function __construct(City $city)
    {
        $this->model = $city;
    }
}
