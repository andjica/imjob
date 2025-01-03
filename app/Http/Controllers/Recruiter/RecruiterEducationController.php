<?php

namespace App\Http\Controllers\Recruiter;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Interfaces\RecruiterEducationInterface;

class RecruiterEducationController extends Controller
{
    protected $recruiterEducationServices;

    public function __construct(RecruiterEducationInterface $recruiterEducationServices)
    {
        $this->recruiterEducationServices = $recruiterEducationServices;
    }

    public function create(Request $request)
    {
        $this->recruiterEducationServices->create($request);
        return redirect()->back()->with('success', 'Education details saved successfully!');
    }

    public function update(Request $request)
    {
        $this->recruiterEducationServices->update($request);
        return redirect()->back()->with('success', 'Education details saved successfully!');

    }
}