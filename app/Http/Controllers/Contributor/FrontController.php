<?php 
namespace App\Http\Controllers\Contributor;

use App\Http\Controllers\Controller;
use App\Interfaces\CityInterface;
use App\Interfaces\ContributorTypeInterface;
use App\Interfaces\CountryInterface;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class FrontController extends Controller
{
    public function __construct(protected CountryInterface $countryService, protected CityInterface $cityServices,
    protected ContributorTypeInterface $contributorTypeServices,private FreelancerInterface $freelancerServices,)
    {
        
    }
    public function index()
    {
        $countries = $this->countryService->getCountries();
        $contributorTypes = $this->contributorTypeServices->getAllContributorTypes();
        return view('contributor.pages.index', compact('countries', 'contributorTypes'));
    }

    public function createPost()
    {
        return view('contributor.pages.post.create');
    }

    public function settings(): Factory|View|Application
    {
        $freelancerId = auth()->user()->recruiter->id;
        $freelancer   = $this->freelancerServices->getFreelancerById($freelancerId);
        return view('company-freelancer.pages.settings', compact('freelancer'));
    }
}