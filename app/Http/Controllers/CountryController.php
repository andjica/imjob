<?php

namespace App\Http\Controllers;

use App\Interfaces\CountryInterface;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    protected $countryServices;

    public function __construct(CountryInterface $countryServices)
    {
        $this->countryServices = $countryServices;
    }

    public function getCurrency($countryId)
    {
        $currency = $this->countryServices->getCurrency($countryId);

        return $currency;
    }

    public function getPhoneCode($countryId)
    {
        $phone = $this->countryServices->getPhoneCode($countryId);

        return $phone;
    }
}
