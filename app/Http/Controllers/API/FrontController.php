<?php
namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;
use App\Interfaces\CountryInterface;

class FrontController extends Controller
{
    protected $countryServices;


    public function __construct(CountryInterface $countryServices)
    {
        
        $this->countryServices = $countryServices;
    }

    public function getCountries()
    {
        $countries = $this->countryServices->getCountries();
        return response()->json([
            'countries' => $countries
        ]);
    }
}