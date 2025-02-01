<?php 
namespace App\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

interface ContributorInterface 
{
    public function create(Request $request);

    public function getAll();
}