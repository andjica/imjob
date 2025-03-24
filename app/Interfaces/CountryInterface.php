<?php 
namespace App\Interfaces;

interface CountryInterface
{
    public function getCountries();
    public function getCurrency(int $countryId);
    public function getPhoneCode(int $countryId);
}