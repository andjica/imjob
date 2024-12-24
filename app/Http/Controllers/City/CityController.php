<?php

namespace App\Http\Controllers\City;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Interfaces\CityInterface;

class CityController extends Controller
{
    protected $cityServices;

    public function __construct(CityInterface $cityServices)
    {
        $this->cityServices = $cityServices;
    }
    public function getCitiesByCountry(int $coutryId)
    {
        $cities = $this->cityServices->getCitiesByCountry($coutryId);
        
        return response()->json([
            'cities' => $cities,
        ]);
    }
}
