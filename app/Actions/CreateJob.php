<?php

namespace App\Actions;

use App\DTO\JobSkillDTO;
use App\Models\Job;
use App\Models\User;
use App\Repositories\JobRepository;
use App\Repositories\JobSkillRepository;
use App\Services\TransactionService;
use Illuminate\Support\Collection;

class CreateJob
{
    public function __construct(
        private JobRepository $jobRepository,
        private JobSkillRepository $jobSkillRepository,
        private TransactionService $transactionService,
    ) {
    }

    public function execute(array $data): ?Job
    {
        return $this->transactionService->run(function () use ($data) {
            //$data = $this->setAdditionalFields($data);

            $job = $this->jobRepository->create(camelToSnakeCase($data));
            $this->saveSkills($job, $this->extractSkills($data));

            return $job;
        });
    }

    /**
     * @return Collection<int, JobSkillDTO>
     */
    private function extractSkills(array $data): Collection
    {
        $requiredSkills = $data['requiredSkills'];
        $moreSkill      = $data['moreSkill']      ?? [];
        $moreSkills     = $data['moreSkills']     ?? [];

        $jobSkills = array_merge(
            $requiredSkills ? [new JobSkillDTO($requiredSkills, true)] : [],
            array_map(function ($skill) {
                return new JobSkillDTO($skill, false);
            }, $moreSkill),
            array_map(function ($skill) {
                return new JobSkillDTO($skill, false);
            }, $moreSkills)
        );

        return collect($jobSkills)->filter();
    }

    /**
     * @param  Collection<int, JobSkillDTO> $skills
     */
    private function saveSkills(Job $job, Collection $skills): void
    {
        /** @var JobSkillDTO $skill */
        foreach ($skills as $skill) {
            if (!$skill->getSkill()) {
                continue;
            }
            $this->jobSkillRepository->create([
                'job_id'      => $job->id,
                'skill'       => $skill->getSkill(),
                'is_required' => $skill->isRequired(),
            ]);
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
