<?php

namespace App\Http\Controllers\Company;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Interfaces\CategoryInterface;
use App\Interfaces\CityInterface;
use App\Interfaces\CountryInterface;
use App\Interfaces\RecruiterInterface;
use App\Interfaces\SubCategoryInterface;
use App\Models\Company;
use App\Services\CompanyTypeServices;

class FrontController extends Controller
{
    protected $countryServices;
    protected $cityServices;
    protected $recruiterServices;
    protected $companyTypeServices;
    protected $categoryServices;
    protected $subCategoryServices;


    public function __construct(CountryInterface $countryServices, CityInterface $cityServices, 
    RecruiterInterface $recruiterServices, CompanyTypeServices $companyTypeServices,
    CategoryInterface $categoryServices, SubCategoryInterface $subCategoryServices)
    {
        $this->countryServices = $countryServices;
        $this->cityServices = $cityServices;
        $this->recruiterServices = $recruiterServices;
        $this->companyTypeServices = $companyTypeServices;
        $this->categoryServices = $categoryServices;
        $this->subCategoryServices = $subCategoryServices;
    }

    public function dashboard()
    {
        $user = User::find(auth()->user()->id) ?? abort(404);
        $company = Company::where('user_id', $user->id)->first();
        if(!$company instanceof Company)
        {
            return redirect('/company/dashboard/information/create');
        }
        return view('company.pages.index');
    }

    public function informationCreate()
    {
        $countries = $this->countryServices->getCountries();
        $companyTypes = $this->companyTypeServices->getAll();
        $categories = $this->categoryServices->getAll();
        
        return view('company.pages.company.create', compact('countries', 'companyTypes', 'categories'));
    }

    

    public function findRecruiters(Request $request)
    {
        $search = $request->input('search');
        $recruiters = $this->recruiterServices->getAllRecruiters($search);

        $company = auth()->user()->company;
        
        return view('company.pages.recruiters.find', compact('recruiters', 'company'));
    }

   
   
}
