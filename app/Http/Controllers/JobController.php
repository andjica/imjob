<?php

namespace App\Http\Controllers;

use App\Actions\CreateJob;
use App\Http\Requests\StoreJobRequest;
use Illuminate\Http\RedirectResponse;

class JobController extends Controller
{
    public function store(StoreJobRequest $request, CreateJob $createJob): RedirectResponse
    {
        $createJob->execute($request->validated());

        return redirect()->route('company-freelancer-dashboard');
    }
}
