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
       /** @var User $user */
        $user = auth()->user();

        // Check if the authenticated user has a contributor record
        if (!$user->contributor) {
            return redirect()->route('contributor-dashboard')->with('error', 'You need a contributor profile to search recruiters.');
        }

        $contributorId = $user->contributor->id;
        $search = $request->input('search');

        // Get recruiters based on search query
        $recruiters = $this->recruiterServices->getAllRecruiters($search);

        // Get company if exists
        $company = $user->company;

        // Get connected recruiters using pivot table
        $connectedRecruiters = $user->contributor->recruiters;
        //return dd($connectedRecruiters);
        // Get recruiters with "Pending" status from pivot table
        $connectedOnPending = $user->contributor->recruiters()
            ->wherePivot('status', 'Pending')
            ->get();

        // Get recruiters with "Active" status from pivot table
        $connectedSuccessfully = $user->contributor->recruiters()
            ->wherePivot('status', 'Active')
            ->get();

        return view('contributor.pages.recruiters.find', compact(
            'recruiters', 
            'company', 
            'connectedRecruiters', 
            'connectedOnPending', 
            'connectedSuccessfully'
        ));
        
        }

        public function getActive()
        {
            $user = auth()->user()->id;
            $contributor = Contributor::where('user_id', $user)->first();
            $activeConnection = $contributor->recruiters()->wherePivot('status', 'Active')->get();

            return view('contributor.pages.connection',compact('activeConnection'));
        }
}
