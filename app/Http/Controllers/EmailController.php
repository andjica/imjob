<?php

namespace App\Http\Controllers;

use App\Interfaces\CompanyInterface;
use App\Mail\AddEmployeesEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    protected $companyServices;

    public function __construct(CompanyInterface $companyServices)
    {
        $this->companyServices = $companyServices;
    }
    public function sendToEmployee(Request $request)
    {
        $companyId = auth()->user()->company->id ?? abort(404);
        $company = $this->companyServices->get($companyId);
        
        $email = $request->get('email');

        if($email)
        {
            Mail::to($email)->send(new AddEmployeesEmail($request, $company));
            return redirect()->back()->with('success', 'You sent email successfully');
        }
        else
        {
            return redirect()->back()->with('error', 'Oops, Something went wrong! Please, try later');
        }

    }
}
