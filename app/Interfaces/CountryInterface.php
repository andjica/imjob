<?php 
namespace App\Interfaces;

interface CountryInterface
{
    public function getCountries();
    public function getCurrency(int $countryId);
}