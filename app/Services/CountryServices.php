<?php 

namespace App\Services;

use App\Interfaces\CountryInterface;
use App\Models\Country;

class CountryServices implements CountryInterface
{
    public function getCountries()
    {
        $countries = Country::orderBy('name', 'asc')->get();
        return $countries;
    }
}