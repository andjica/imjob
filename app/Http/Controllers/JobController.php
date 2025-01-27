<?php

namespace App\Http\Controllers;

use App\Actions\CreateJob;
use Illuminate\Http\Request;
use App\Interfaces\JobInterface;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StoreJobRequest;

class JobController extends Controller
{
    
    public function store(StoreJobRequest $request, CreateJob $createJob): RedirectResponse
    {
       
        $createJob->execute($request->validated());

        return redirect()->route('company-freelancer-dashboard');
    }

    
}
