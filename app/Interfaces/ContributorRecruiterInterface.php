<?php

namespace App\Interfaces;

use App\Http\Requests\ChangeStatusRequest;

interface ContributorRecruiterInterface
{
    public function changeStatus(ChangeStatusRequest $changeStatusRequest): bool;
}
