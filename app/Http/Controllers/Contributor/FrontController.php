<?php 
namespace App\Http\Controllers\Contributor;

use App\Models\Post;
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

class FrontController extends Controller
{
    protected  $countryServices;
    protected  $cityServices;
    protected  $contributorTypeServices;
    protected  $postServices;

    public function __construct(CountryInterface $countryServices, CityInterface $cityServices, 
    ContributorTypeInterface $contributorTypeServices, PostInterface $postServices)
    {
        $this->countryServices = $countryServices;
        $this->cityServices = $cityServices;
        $this->contributorTypeServices = $contributorTypeServices;
        $this->postServices = $postServices;
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
}