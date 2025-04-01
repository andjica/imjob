<?php
namespace App\Http\Controllers\API;
use App\Interfaces\CityInterface;
use App\Http\Controllers\Controller;
use App\Interfaces\CountryInterface;

class FrontController extends Controller
{
    protected $countryServices;
    protected $cityServices;

    public function __construct(CountryInterface $countryServices, CityInterface $cityServices)
    {
        $this->countryServices = $countryServices;
        $this->cityServices = $cityServices;


    }

    public function getCountries()
    {
        $countries = $this->countryServices->getCountries();

        return response()->json([
            'countries' => $countries,
        ]);
    }

    public function getPhoneCode($countryId)
    {
        $phone = $this->countryServices->getPhoneCode($countryId);

        return response()->json([
            'phone' => $phone,
        ]);
    }

    public function getCitiesByCountry($coutryId)
    {
        $cities = $this->cityServices->getCitiesByCountry($coutryId);
        
        return response()->json([
            'cities' => $cities,
        ]);
    }
}