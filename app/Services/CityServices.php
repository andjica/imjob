<?php 

namespace App\Services;

use App\Models\City;
use App\Models\Country;
use App\Interfaces\CityInterface;
use Illuminate\Support\Arr;

class CityServices implements CityInterface
{
  public function getCitiesByCountry(int $countryId)
  {
        $country = Country::find($countryId) ?? abort(404);

        if($country)
        {
            $cities = City::where('country_id', $countryId)->get();
            return $cities;
        }
  }

  public function getAll()
  {
      $cities = City::get();
      return $cities;
  }
}
