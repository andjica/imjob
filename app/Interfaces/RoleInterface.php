<?php

namespace App\Interfaces;

use App\Models\User;
use Illuminate\Http\Request;
use Ramsey\Uuid\Type\Integer;

interface RoleInterface
{
    /**
     * Get all roles.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllRoles();

    public function updateRole(int $roleId);

}