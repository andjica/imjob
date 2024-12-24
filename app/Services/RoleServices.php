<?php

namespace App\Services;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Interfaces\RoleInterface;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request as HttpRequest;

class RoleServices implements RoleInterface
{
    /**
     * Get all roles.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllRoles()
    {
        return Role::whereIn('name', ['company', 'recruiter'])->orderBy('name', 'asc')->get();
    }

    public function updateRole(int $roleId)
    {
        $userId = auth()->user()->id;
        $user = User::find($userId) ?? abort(404); 


        if (!$roleId) {
            return abort(404);
        }
 
        if ($roleId != 2 && $roleId != 3) {
            return abort(404);
        }

        $user->id = $userId; 
        $user->role_id = $roleId;    

        try {
           
            $user->save();
            return $user;

        }catch (\Exception) {
            return abort(500);
        }
    }
   
}