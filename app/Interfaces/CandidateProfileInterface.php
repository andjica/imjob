<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface CandidateProfileInterface 
{
    public function store(Request $request);
    public function update(Request $request, $userId);

    public function get($userId);
}