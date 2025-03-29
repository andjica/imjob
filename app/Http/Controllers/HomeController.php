<?php

namespace App\Http\Controllers;

use App\Interfaces\CategoryInterface;
use App\Interfaces\CompanyInterface;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    protected $categoryServices;
    protected $companyServices;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(CategoryInterface $categoryServices, CompanyInterface $companyServices)
    {
        $this->middleware(['auth','verified']);
        $this->categoryServices = $categoryServices;
        $this->companyServices = $companyServices;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        
        if(auth()->user()->role_id == null)
        { 
            return redirect('choose/role');

        }
        //admin
        if(auth()->user()->role_id == 1)
        {
            return redirect('admin/dashboard/companies');
        }
        else if(auth()->user()->role_id == 2)
        {
         
            if(!auth()->user()->company)
            {
                return redirect('/company/dashboard/information/create');
            }
            else
            {
                //check if company is active - admin gives company activation
                $inactiveCompany = Company::where('user_id', auth()->user()->id)->where('active', 0)->first();

                if($inactiveCompany)
                {
                    //company need to wait for dashboard
                    return redirect('/account/activation-pending');
                }
                else
                {
                    //if company is active check which type of company is it
                        $company = auth()->user()->company;
                        
                        //check if company is freelancer type
                        if($company)
                        {
                            if($company->company_type_id == 3)
                            {
                               
                                return redirect('/company/freelancer/dashboard');
                            } 
                            return redirect('company/dashboard');
                        }
                        
                }
            }

            
        }
        //contributor
        else if(auth()->user()->role_id == 4)
        {
            return redirect('contributor/dashboard');
        }
        else 
        {
            //its recruiter
            return redirect('recruiter/dashboard');
        }
       
        
    }

    public function chooseRole()
    {
        return view('auth.choose-role');
    }

    //if company has status 0 means is not activated from admin
    //if user doesnt have company, user must be recruiter
    public function pendingActivation()
    {
        $companyExists = auth()->user()->company->id;
        
        if($companyExists)
        {
            $company = Company::where('user_id', auth()->user()->id)->first();
            
            //check if company is active 
            if($company->active == 1)
            {
                if($company->company_type_id == 3)
                {
                    //if company is freelancer - need to make freelancer(recruiter) record before goes to dash
                    // if (is_null($company?->recruiter)) {
                    //     return redirect('/company/dashboard/information/freelancer/create');
                    // }
                    // else{
                        return redirect('/company/freelancer/dashboard');
                    // }
                    
                }
                else
                {
                    return redirect('/company/dashboard');
                }
              
            }
            else
            {
               
                
                return view('company.pages.company.pending-activation');
            }
           
            
            
        }
        else
        {
            return redirect('/home');
        }
        
       
    }

   

    public function createFreelancer()
    {
        
        // $secret = config('app.key');

        // $expectedToken = hash_hmac('sha256', $companyId, $secret);
    
       // if (!hash_equals($expectedToken, $token)) {
           // abort(403, 'Neautorizovan pristup.');
        //}
    
       // $company = $this->companyServices->get($companyId);

        $categories = $this->categoryServices->getAll();
        
        return view('company.pages.freelancer.create', compact('categories'));
        
       
    }
}
