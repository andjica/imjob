<?php 

namespace App\Interfaces;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;


interface CityInterface
{
    public function getCitiesByCountry(int $countryId);
    public function getAll();
}