<?php

namespace App\Http\Controllers\Front;

use App\Models\City;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LandingController extends Controller
{
    public function index()
    {
        return view('front.pages.index');
    }

    public function getContactUs() {
        return view('front.pages.contact');
    }

    public function getAboutUs() {
        return view('front.pages.about');
    }
}
