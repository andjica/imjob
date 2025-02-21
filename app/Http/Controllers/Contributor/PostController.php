<?php

namespace App\Http\Controllers\Contributor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function store(Request $request)
    {
        return dd($request->all());
    }
}
