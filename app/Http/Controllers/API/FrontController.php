<?php
namespace App\Http\Controllers\API;
use App\Interfaces\CityInterface;
use App\Http\Controllers\Controller;
use App\Interfaces\CountryInterface;
use App\Repositories\JobRepository;

class FrontController extends Controller
{
    protected $countryServices;
    protected $cityServices;
    protected $jobServices;

    public function __construct(CountryInterface $countryServices, CityInterface $cityServices, JobRepository $jobServices)
    {
        $this->countryServices = $countryServices;
        $this->cityServices = $cityServices;
        $this->jobServices = $jobServices;

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

    public function activeJobs()
    {
        $jobsRandomFive = $this->jobServices->randomActiveJobs();

        return response()->json([
            'randomFiveJobs' => $jobsRandomFive
        ]);

    }
}