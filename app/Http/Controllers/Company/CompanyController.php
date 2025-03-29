<?php

namespace App\Http\Controllers\Company;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Interfaces\CompanyInterface;
use App\Mail\CompanyActivationEmail;
use App\Mail\CompanyPendingActivationEmail;
use Illuminate\Support\Facades\Mail;

use function PHPSTORM_META\type;

class CompanyController extends Controller
{
    protected $companyService;

    public function __construct(CompanyInterface $companyService)
    {
        $this->companyService = $companyService;
    }

    //admin accept company
    public function accept($id)
    {
        $company = $this->companyService->acceptCompany($id);
        
        Mail::to($company->email) // Send email to the company owner
        ->cc(env('ADMIN_EMAIL')) // CC to the admin
        ->send(new CompanyActivationEmail($company));
      
        
        return redirect()->back()->with('success', 'You accept company successfully!');
    }

    //admin reject company
    public function reject($id)
    {
        $this->companyService->rejectCompany($id);
        return redirect()->back()->with('success', 'You delete company successfully');
    }


    //someone new on platform register new company
    public function store(Request $request)
    {
       
        // Call the service to create the company
        $company = $this->companyService->create($request);
        //return dd($company->companyType->name);
        if($company->companyType->name === "Freelancer")
        {
            return redirect('/company/dashboard/information/freelancer/create');
        }
        else
        {
            
            Mail::to($company->email) // Send email to the company owner
            ->cc(env('ADMIN_EMAIL')) // CC to the admin
            ->send(new CompanyPendingActivationEmail($company));
            return redirect('/account/activation-pending');
        }
       
       
    }

    public function update(Request $request)
    {
            
        // Call the service to update the company
        //return dd($request->all());
        
        $company = $this->companyService->update($request);
        
        //return dd($company);
        return redirect()->back()->with('success', 'You updated your data successfully');
    }
}
