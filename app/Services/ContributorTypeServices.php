<?php 

namespace App\Services;

use App\Models\ContributorType;
use App\Interfaces\ContributorTypeInterface;

class ContributorTypeServices implements ContributorTypeInterface
{
    public function getAllContributorTypes()
    {
        return ContributorType::all();
    }
}