<?php

namespace App\Services;


use App\Interfaces\JobTypeInterface;
use App\Models\JobType;

class JobTypeServices implements JobTypeInterface
{
    public function getAll()
    {
        $jobTypes = JobType::all();

        return $jobTypes;
    }
}