<?php 
namespace App\Http\Controllers\Contributor;

use App\Http\Controllers\Controller;
use App\Interfaces\CityInterface;
use App\Interfaces\ContributorTypeInterface;
use App\Interfaces\CountryInterface;

class FrontController extends Controller
{
    public function __construct(protected CountryInterface $countryService, protected CityInterface $cityServices,
    protected ContributorTypeInterface $contributorTypeServices)
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
}