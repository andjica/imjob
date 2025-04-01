<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface CandidateProfileInterface 
{
    public function store(Request $request);
}