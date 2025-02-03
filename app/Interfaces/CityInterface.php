<?php 

namespace App\Interfaces;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;

interface CityInterface
{
    public function getCitiesByCountry(int $countryId);
    public function getAll();
}