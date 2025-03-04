<?php

namespace App\Http\Controllers\Contributor;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Models\Contributor;
use App\Interfaces\CityInterface;
use App\Interfaces\ContributorTypeInterface;
use App\Interfaces\CountryInterface;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use App\Interfaces\ContributorInterface;
use App\Interfaces\PostInterface;
use App\Interfaces\RecruiterInterface;

class FrontController extends Controller
{
    protected  $countryServices;
    protected  $cityServices;
    protected  $contributorTypeServices;
    protected  $postServices;
    protected $countriesServices;
    protected $citiesServices;
    protected $recruiterServices;

    public function __construct(
        CountryInterface $countryServices,
        CityInterface $cityServices,
        ContributorTypeInterface $contributorTypeServices,
        PostInterface $postServices,
        CountryInterface $countriesServices,
        CityInterface $citiesServices,
        RecruiterInterface $recruiterServices
    ) {
        $this->countryServices = $countryServices;
        $this->cityServices = $cityServices;
        $this->contributorTypeServices = $contributorTypeServices;
        $this->postServices = $postServices;
        $this->countriesServices = $countriesServices;
        $this->citiesServices = $citiesServices;
        $this->recruiterServices = $recruiterServices;
    }
    public function index()
    {
        $countries = $this->countryServices->getCountries();
        $contributorTypes = $this->contributorTypeServices->getAllContributorTypes();
        return view('contributor.pages.index', compact('countries', 'contributorTypes'));
    }

    public function createPost()
    {

        return view('contributor.pages.post.create');
    }

    public function settings(): Factory|View|Application
    {
        $contributorId = auth()->user()->contributor->id;
        $contributor   = Contributor::find($contributorId) ?? abort(404);
        return view('contributor.pages.settings', compact('contributor'));
    }

    public function allPost()
    {
        $contributorId = auth()->user()->contributor->id;
        $posts = $this->postServices->getPostsByContributor($contributorId);

        return view('contributor.pages.post.all', compact('posts'));
    }

    public function companies()
    {
        return view('contributor.pages.companies');
    }
    public function recruiter()
    {
        return view('contributor.pages.recruiter');
    }
    public function edit()
    {
        $contributorId = auth()->user()->contributor->id;
        $contributor   = Contributor::find($contributorId) ?? abort(404);

        $contributorTypes = $this->contributorTypeServices->getAllContributorTypes();
        $countries = $this->countriesServices->getCountries();
        $cities    = $this->citiesServices->getCitiesByCountry($contributor->country_id);

        return view('contributor.pages.edit', compact('contributor', 'contributorTypes', 'countries', 'cities'));
    }
    public function findRecruiters(Request $request)
    {
        $search = $request->input('search');
        $recruiters = $this->recruiterServices->getAllRecruiters($search);

        $company = auth()->user()->company;
        
        return view('contributor.pages.recruiters.find', compact('recruiters', 'company'));
    }
}
