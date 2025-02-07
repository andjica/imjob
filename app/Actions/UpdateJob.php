<?php

namespace App\Actions;

use App\DTO\JobSkillDTO;
use App\Models\Job;
use App\Models\User;
use App\Repositories\JobRepository;
use App\Repositories\JobSkillRepository;
use App\Services\TransactionService;
use Illuminate\Support\Collection;

class UpdateJob
{
    public function __construct(
        private JobRepository $jobRepository,
        private JobSkillRepository $jobSkillRepository,
        private TransactionService $transactionService,
    ) {
    }

    public function execute(int $jobId, array $data): ?Job
    {
        return $this->transactionService->run(function () use ($jobId, $data) {
            $job = $this->jobRepository->find($jobId);
            
            if (!$job) {
                return null; // Handle not found case
            }

            $data = $this->setAdditionalFields($data);

            // Update job details
            $this->jobRepository->update($jobId, camelToSnakeCase($data));

            // Update job skills
            $this->updateSkills($job, $this->extractSkills($data));

            return $job->fresh();
        });
    }

    /**
     * @return Collection<int, JobSkillDTO>
     */
    private function extractSkills(array $data): Collection
    {
        // Ensure required skill exists
        $requiredSkill = $data['requiredSkills'] ?? null;
        $optionalSkills = array_merge(
            $data['moreSkill'] ?? [],
            $data['moreSkills'] ?? []
        );

        // Prevent empty skills from being processed
        $jobSkills = collect();

        if (!empty($requiredSkill)) {
            $jobSkills->push(new JobSkillDTO($requiredSkill, true));
        }

        foreach ($optionalSkills as $skill) {
            if (!empty($skill)) {
                $jobSkills->push(new JobSkillDTO($skill, false));
            }
        }

        return $jobSkills;
    }

    /**
     * Updates job skills: removes old ones and adds new ones.
     *
     * @param Job $job
     * @param Collection<int, JobSkillDTO> $skills
     */
    private function updateSkills(Job $job, Collection $skills): void
    {
        // Delete only optional skills, keep the required one
        $this->jobSkillRepository->deleteOptionalSkills($job->id);

        foreach ($skills as $skill) {
            if (!$skill->getSkill()) {
                continue;
            }

            // Check if skill already exists to avoid duplicates
            $existingSkill = $this->jobSkillRepository->findByJobIdAndSkill($job->id, $skill->getSkill());
            if (!$existingSkill) {
                $this->jobSkillRepository->create([
                    'job_id'      => $job->id,
                    'skill'       => $skill->getSkill(),
                    'is_required' => $skill->isRequired(),
                ]);
            }
        }
    }

    private function setAdditionalFields(array $data): array
    {
        /** @var ?User $user */
        $user = auth()->user();

        $data['recruiter_id'] = $user?->recruiter?->id ?? null;

        return $data;
    }
}
