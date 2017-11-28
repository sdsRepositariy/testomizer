<?php

namespace App\Services\Communities\Filters;

use App\Contracts\Common\FilterInterface as FilterInterface;
use App\Contracts\Community\CountryRepositoryInterface as CountryRepo;
use App\Contracts\Community\RegionRepositoryInterface as RegionRepo;
use App\Contracts\Community\CityRepositoryInterface as CityRepo;
use App\Contracts\Users\UserRepositoryInterface as UserRepo;

class LocationFilter implements FilterInterface
{
    /**
     * The location model names
     *
     * @var string
    */
    protected $locationModels = ['country', 'region', 'city'];

    /**
     * The country repository implementation.
     *
     * @var CountryRepository
     */
    protected $country;

    /**
     * The region repository implementation.
     *
     * @var RegionRepository
     */
    protected $region;

    /**
     * The city repository implementation.
     *
     * @var CityRepository
     */
    protected $city;

    /**
     * The user repository implementation.
     *
     * @var UserRepository
    */
    protected $user;

    /**
     * Create a new filter instance.
     *
     * @return void
     */
    public function __construct(CountryRepo $country, RegionRepo $region, CityRepo $city, UserRepo $user)
    {
        $this->country = $country;

        $this->region = $region;

        $this->city = $city;

        $this->user = $user;
    }

    /**
     * The query filter
     *
     * @param Illuminate/Database/Eloquent/Builder $query
     * @param string $attribute
     *
     * @return array
    */
    public function apply($attribute)
    {
        //Check if the filter key in the scope of the location models
        if (isset($attribute)) {
            $attributeKey = implode(array_keys($attribute));
            if (in_array($attributeKey, $this->locationModels)) {
                //Apply filter
                $location = $this->getLocation($attributeKey, $attribute[$attributeKey]);
            } else {
                abort(404);
            }
        }

        //The default or given values for filters stored in the session
        //so empty location array in the session means the first filter call.
        if (session('location') == null) {
            $location = $this->getDefault();
        }

        return ['cities_id' => $this->getSelectedCities()];
    }

    /**
     * Store selected values in the session.
     *
     * @param string $attributeKey
     * @param string $attribute
     *
     * @return void
    */
    protected function storeSelected($attributeKey, $attribute)
    {
        //Check if the model exist
        if ($attribute != 'all') {
            $attribute = $this->$attributeKey->findById($attribute)->id;
        }

        //Store selected value in the session
        if ($attributeKey == 'country') {
            session([
                'location.country_selected' => $attribute,
                'location.region_selected' => 'all',
                'location.city_selected' => 'all'
            ]);
        } elseif ($attributeKey == 'region') {
            if ($attribute != 'all') {
                $region = $this->region->findByIdWith($attribute, ['country']);
                session(['location.country_selected' => $region->country->id]);
            }
            session([
                'location.region_selected' => $attribute,
                'location.city_selected' => 'all'
            ]);
        } else {
            if ($attribute != 'all') {
                $city = $this->city->findByIdWith($attribute, ['region.country']);
                session([
                    'location.country_selected' => $city->region->country->id,
                    'location.region_selected' => $city->region->id,
                ]);
            }
            session([
                'location.city_selected' => $attribute
            ]);
        }
    }

    /**
     * Get default values
     *
     * @return array
    */
    protected function getDefault()
    {
        //The default location - location of the authenticated user.
        $authUserId = $this->user->getAuthUser()->id;
        $authUserInst = $this->user->findByIdWith($authUserId, ['community.city.region.country']);

        $country = $authUserInst->community->city->region->country->id;
        $region = $authUserInst->community->city->region->id;
        $city = $authUserInst->community->city->id;

        //Store default values in the session
        session([
            'location.country_selected' => $authUserInst->community->city->region->country->id,
            'location.region_selected' => $authUserInst->community->city->region->id,
            'location.city_selected' => $authUserInst->community->city->id,
        ]);

        return [
            'country' => $country,
            'region' => $region,
            'city' => $city
        ];
    }

    /**
     * Retrive selected cities.
     *
     * @return array
    */
    protected function getSelectedCities()
    {
        $country = session('location.country_selected');
        $region = session('location.region_selected');
        $city = session('location.city_selected');

        if ($city == 'all') {
            if ($region == 'all') {
                if ($country == 'all') {
                    $cities = $this->city->all();
                } else {
                    $cities = $this->country->getCityByCountry($country);
                }
            } else {
                $cities = $this->region->getCityByRegion($region);
            }
        } else {
            $cities = $this->city->getById($city);
        }
      
        return $cities->pluck('id')->toArray();
    }
}
