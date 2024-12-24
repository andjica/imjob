<?php

namespace App\Http\Controllers;

use App\Models\Recruiter;
use Illuminate\Http\Request;
use App\Interfaces\RecruiterInterface;

class RecruiterController extends Controller
{
    protected $recruiterServices;

    public function __construct(RecruiterInterface $recruiterServices)
    {  
        $this->recruiterServices = $recruiterServices;     
    }
    public function callRecruiter(Request $request, Recruiter $recruiter)
    {
        $company = auth()->user()->company;

        // Attach recruiter to company if not already connected
        if (!$company->recruiters->contains($recruiter->id)) {
            $company->recruiters()->attach($recruiter->id, ['status' => 'onpending']);
        }
    
        return redirect()->back()->with('success', 'Recruiter called successfully!');
    }

    public function store(Request $request)
    {
        
        $this->recruiterServices->store($request);
      
        return redirect('/account/activation-pending');
    }
}
