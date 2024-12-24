<?php

namespace App\Services;

use App\Interfaces\CompanyTypeInterface;
use App\Models\CompanyType;

class CompanyTypeServices implements CompanyTypeInterface
{
    public function getAll()
    {
        $companytypes = CompanyType::All();

        return $companytypes;
    }
    
}