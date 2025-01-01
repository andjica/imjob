<?php

namespace App\Http\Controllers\CompanyFreelancer;

use App\Actions\FollowCompany;
use App\Http\Controllers\Controller;
use App\Http\Requests\FollowCompanyRequest;
use App\Interfaces\CategoryInterface;
use App\Interfaces\CityInterface;
use App\Interfaces\CompanyFreelancerInterface;
use App\Interfaces\CompanyInterface;
use App\Interfaces\CompanyTypeInterface;
use App\Interfaces\CountryInterface;
use App\Interfaces\FreelancerInterface;
use App\Interfaces\SubCategoryInterface;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use App\Interfaces\JobTypeInterface;

class FrontController extends Controller
{
    public function __construct(
        private CompanyFreelancerInterface $companyFreelancerServices,
        private CategoryInterface $categoryServices,
        private FreelancerInterface $freelancerServices,
        private CountryInterface $countriesServices,
        private SubCategoryInterface $subCategoriesServices,
        private CityInterface $citiesServices,
        private CompanyTypeInterface $companyTypesServices,
        private CompanyInterface $companyServices
    ) {
    protected $companyFreelancerServices;
    protected $categoryServices;
    protected $freelancerServices;
    protected $countriesServices;
    protected $subCategoriesServices;
    protected $citiesServices;
    protected $companyTypesServices;
    protected $companyServices;
    protected $jobTypesServices;

    public function __construct(CompanyFreelancerInterface $companyFreelancerServices, CategoryInterface $categoryServices
    ,FreelancerInterface $freelancerServices,  CountryInterface $countriesServices
    ,SubCategoryInterface $subCategoriesServices, CityInterface $citiesServices,
    CompanyTypeInterface $companyTypesServices, CompanyInterface $companyServices,
    JobTypeInterface $jobTypesServices)
    {
        $this->companyFreelancerServices = $companyFreelancerServices;
        $this->categoryServices = $categoryServices;
        $this->freelancerServices = $freelancerServices;
        $this->countriesServices = $countriesServices;
        $this->subCategoriesServices = $subCategoriesServices;
        $this->citiesServices = $citiesServices;
        $this->companyTypesServices = $companyTypesServices;
        $this->companyServices = $companyServices;
        $this->jobTypesServices = $jobTypesServices;
    }

    public function dashboard()
    {
        /** @var User $user */
        $user   = auth()->user();
        $userId = $user->id;

        $freelancer = $this->companyFreelancerServices->findFreelancer($userId) ?? abort(404);
        return view('company-freelancer.pages.index', compact('freelancer'));
    }

    public function editFreelancer()
    {
        $categories   = $this->categoryServices->getAll();
        $freelancerId = auth()->user()->recruiter->id;
        $freelancer   = $this->freelancerServices->getFreelancerById($freelancerId);

        $countries     = $this->countriesServices->getCountries();
        $subCategories = $this->subCategoriesServices->getAll();
        $cities        = $this->citiesServices->getAll();
        $companyTypes  = $this->companyTypesServices->getAll();
        return view('company-freelancer.pages.freelancer.edit', compact(
            'categories',
            'freelancer',
            'countries',
            'subCategories',
            'cities',
            'companyTypes'
        ));
    }

    public function editCompany()
    {
        $user    = auth()->user()->id;
        $company = $this->companyServices->getCompanyByRecruiter($user);

        $categories    = $this->categoryServices->getAll();
        $categoryId    = $company->category_id;
        $subCategories = $this->subCategoriesServices->getAllByCategoryId($categoryId);

        $countries = $this->countriesServices->getCountries();
        $cities    = $this->citiesServices->getCitiesByCountry($company->country_id);

        $companyTypes = $this->companyTypesServices->getAll();

        return view('company-freelancer.pages.company.edit', compact(
            'company',
            'categories',
            'countries',
            'subCategories',
            'cities',
            'companyTypes'
        ));
    }

    public function settings()
    {
        $freelancerId = auth()->user()->recruiter->id;
        $freelancer   = $this->freelancerServices->getFreelancerById($freelancerId);
        return view('company-freelancer.pages.settings', compact('freelancer'));
    }

    public function findCompanies()
    {
        $companies = $this->companyServices->getAllCompanies();
        return view('company-freelancer.pages.find-companies', compact('companies'));
    }

    public function followCompany(FollowCompanyRequest $request, FollowCompany $followCompany): JsonResponse
    {
        $followCompany->execute((int) $request->get('company_id'));

        // Example response
        return response()->json([
            'success' => true,
            'message' => 'Follow request sent successfully.',
        ]);
    }

    public function detailsCompany()
    {
        //dodaj service za getCompany by id i vrati u blade :)

        return view('company-freelancer.pages.company.details');
    }

    public function createJob()
    {
        $countries = $this->countriesServices->getCountries();
        $categories = $this->categoryServices->getAll();
        $jobTypes = $this->jobTypesServices->getAll();

        return view('company-freelancer.pages.job.create', compact('countries', 'categories', 'jobTypes'));
    }







}
