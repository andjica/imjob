<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        return view('front.pages.index');
    }

    public function getContactUs(Request $request) {
        // return dd($request->all());
        return view('front.pages.contact');
    }

    public function getAboutUs() {
        return view('front.pages.about');
    }
}
