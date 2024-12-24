<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface RecruiterEducationInterface
{
    public function create(Request $request);
    public function update(Request $request);  
}