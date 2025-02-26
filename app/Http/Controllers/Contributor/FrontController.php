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

    public function settings(): Factory|View|Application
    {
        $contributorId = auth()->user()->contributor->id;
        $contributor   = Contributor::find($contributorId) ?? abort(404);
        return view('contributor.pages.settings', compact('contributor'));
    }

    public function allPost()
    {
        //stvaiti posle u service
        $contributorId = auth()->user()->contributor->id ?? abort(404);
        $posts = Post::where('contributor_id', $contributorId)->get() ?? abort(404);
        
        return view('contributor.pages.post.all', compact('posts'));
    }
}