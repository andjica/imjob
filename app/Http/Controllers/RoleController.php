<?php

namespace App\Http\Controllers;

use App\Interfaces\RoleInterface;
use App\Models\Company;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    protected $roleService;

    public function __construct(RoleInterface $roleService)
    {
        $this->roleService = $roleService;
    }

    public function updateUserRole(Request $request)
    {
        
        $roleId = $request->get('roleId'); 
        
        $userUpdated = $this->roleService->updateRole($roleId);
        
        if ($userUpdated) {
            if($userUpdated->role_id == 2)
            {
                
                $company = Company::where('user_id', auth()->user()->id)->first();
                
                if(!$company instanceof Company)
                {
                    return redirect('/company/dashboard/information/create');
                    
                }

                return redirect('/company/dashboard');
            }
            else if($userUpdated->role_id == 4)
            {
                return redirect('/contributor/dashboard');
            }
            else
            {
                // go to recruiter dashboard
                return redirect('/recruiter/dashboard/');
            }
        } else {
            return response()->json(['message' => 'Failed to update role'], 400); 
        }
    }
    
}
