<?php

namespace App\Contracts\Community;

interface CountryRepositoryInterface
{
    /**
     * Get all cities belongs to given country.
     *
     * @param int $country
     *
     * @return Illuminate\Database\Eloquent\Collection
    */
    public function getCityByCountry($country);

    /**
     * Get country by given value.
     *
     * @param mixed $country
     *
     * @return Illuminate\Database\Eloquent\Collection
    */
    public function getCountry($country);
}
