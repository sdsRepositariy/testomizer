<?php

namespace App\Repositories\Community;

use App\Contracts\Community\CountryRepositoryInterface as CountryRepoInterface;
use App\Repositories\AbstractRepository as AbstractRepository;
use App\Models\Communities\Country as Country;

class CountryRepository extends AbstractRepository implements CountryRepoInterface
{
    /**
     * The country model.
     *
     * @var Illuminate\Database\Eloquent\Model
     */
    protected $model;

    /**
     * Create a new repositoriy instance.
     *
     * @return void
     */
    public function __construct(Country $country)
    {
        $this->model = $country;
    }

    /**
     * Get all cities belongs to given country.
     *
     * @param int $country
     *
     * @return Illuminate\Database\Eloquent\Collection
    */
    public function getCityByCountry($country)
    {
        return $this->getById($country)->cities;
    }

    /**
     * Get country by given value.
     *
     * @param mixed $country
     *
     * @return Illuminate\Database\Eloquent\Collection
    */
    public function getCountry($country)
    {
        if ($country == 'all') {
            return $this->getAllWith('region.city');
        } else {
            return $this->findByIdWith($country, 'region.city');
        }
    }
}
