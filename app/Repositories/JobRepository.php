<?php

namespace App\Repositories;

use App\Models\Job;
use Illuminate\Database\Eloquent\Collection;

class JobRepository
{
    public function all(): Collection
    {
        return Job::all();
    }

    public function find(int $id): ?Job
    {
        return Job::find($id);
    }

    public function create(array $attributes): Job
    {
        $model = new Job();
        $model->fill($attributes);
        $model->save();
        return $model;
    }

    public function update(int $id, array $attributes): ?Job
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
}
