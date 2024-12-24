<?php

namespace App\Http\Controllers\CompanyFreelancer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Interfaces\FreelancerInterface;
use App\Interfaces\RecruiterInterface;

class FreelancerController extends Controller
{

    protected $recruiterServices;

    protected $freelancerServices;

    public function __construct(RecruiterInterface $recruiterServices, FreelancerInterface $freelancerServices)
    {  
        $this->recruiterServices = $recruiterServices;     
        $this->freelancerServices = $freelancerServices;
    }
    public function store(Request $request)
    {
        $this->recruiterServices->store($request);
      
        return redirect('/account/activation-pending');
    }

    public function update(Request $request)
    {
        $this->freelancerServices->updateFreelancer($request);
        return redirect()->back()->with('success', 'You upddated information successfully');
    }
}
