<?php

namespace App\Interfaces;

use App\Http\Requests\ChangeStatusRecruiterContributorRequest;
use App\Http\Requests\ChangeStatusRequest;

interface ContributorRecruiterInterface
{
    public function changeStatus(ChangeStatusRecruiterContributorRequest $changeStatusRequest): bool;
}
