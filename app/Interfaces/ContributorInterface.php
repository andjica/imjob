<?php 
namespace App\Interfaces;

use Illuminate\Http\Request;

interface ContributorInterface 
{
    public function create(Request $request);
}