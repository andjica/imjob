<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface FreelancerInterface
{
   
    public function getFreelancerById(int $freelancerId);
    public function updateFreelancer(Request $request);
    public function updateProfileImage(int $freelancerId, Request $request);
}
