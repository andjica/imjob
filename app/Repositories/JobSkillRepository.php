<?php

namespace App\Repositories;

use App\Models\JobSkill;
use Illuminate\Support\Collection;

class JobSkillRepository
{
    public function all(): Collection
    {
        return JobSkill::all();
    }

    public function find(int $id): ?JobSkill
    {
        return JobSkill::find($id);
    }

    public function create(array $attributes): JobSkill
    {
        $model = new JobSkill();
        $model->fill($attributes);
        $model->save();
        return $model;
    }

    public function update(int $id, array $attributes): ?JobSkill
    {
        $model = $this->find($id);
        if ($model) {
            $model->fill($attributes);
            $model->save();
            return $model;
        }
        return null;
    }

    public function delete(int $id): bool
    {
        $model = $this->find($id);
        return $model ? $model->delete() : false;
    }

     /**
     * Deletes only optional skills (is_required = false) for a given job.
     */
    public function deleteOptionalSkills(int $jobId): void
    {
        JobSkill::where('job_id', $jobId)->where('is_required', false)->delete();
    }

    /**
     * Finds a skill by job ID and skill name.
     */
    public function findByJobIdAndSkill(int $jobId, string $skill): ?JobSkill
    {
        return JobSkill::where('job_id', $jobId)
            ->where('skill', $skill)
            ->first();
    }
}
