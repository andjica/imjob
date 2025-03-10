<?php
namespace App\Interfaces;

use App\Http\Requests\ChangeStatusRequest;

interface CompanyRecruiterInterface
{
    /**
     * Change the follow request status
     *
     * @param int $entityId
     * @param int $companyId
     * @param int $recruiterId
     * @param string $status
     * @param string $inviteType
     * @return bool
     */
    public function changeStatus(ChangeStatusRequest $changeStatusRequest): bool;
    public function delete(int $companyId, int $recruiterId);
}
