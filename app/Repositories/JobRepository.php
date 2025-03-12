<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\Job;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

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

     // New method to find active jobs by recruiter ID by Andjica
    public function findActiveByRecruiterId(int $recruiterId)
    {
        return Job::where('recruiter_id', $recruiterId)
            ->where('valid_until', '>=', now()) 
            ->orderBy('created_at', 'desc')
            ->paginate(4);
    }

     // New method to find active jobs by recruiter ID by Andjica
     public function findInactiveByRecruiterId(int $recruiterId)
     {
        //  return Job::where('recruiter_id', $recruiterId)
        //      ->where('valid_until', '<=', now()) 
        //      ->orderBy('created_at', 'desc')
        //      ->paginate(4);

            $query = Job::with(['category', 'subCategory', 'country', 'city']) 
                        ->where('valid_until', '<=', now()) 
                        ->where('recruiter_id', $recruiterId)
                        ->orderBy('created_at', 'desc'); 
        
            if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                    ->orWhereHas('category', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('subCategory', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('country', function ($q) use ($search) { 
                        $q->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('city', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
                });
            }
        
            return $query->paginate(10);
    }

    //find Active by Company id
    public function searchJobsFromCompany(?string $search = null, int $companyId): LengthAwarePaginator
    {
        $query = Job::with(['company','category', 'subCategory', 'country', 'city']) 
        ->where('valid_until', '>', Carbon::today())
        ->where('company_id', $companyId)
        ->orderBy('created_at', 'desc'); 

        if (!empty($search)) {
        $query->where(function ($q) use ($search) {
        $q->where('title', 'like', "%{$search}%")
        ->orWhere('job_world_type', 'like', "%{$search}%") 
        ->orWhereHas('company', function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%");
        })
        ->orWhereHas('category', function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%");
        })
        ->orWhereHas('subCategory', function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%");
        })
        ->orWhereHas('country', function ($q) use ($search) { 
            $q->where('name', 'like', "%{$search}%");
        })
        ->orWhereHas('city', function ($q) use ($search) { 
            $q->where('name', 'like', "%{$search}%");
        });
        });
        }

        return $query->paginate(10);
    }

    // New method to find active jobs by company ID by Andjica
    public function findInactiveFromCompanyId(int $companyId)
    {

           $query = Job::with(['category', 'subCategory', 'country', 'city']) 
                       ->where('valid_until', '<=', now()) 
                       ->where('company_id', $companyId)
                       ->orderBy('created_at', 'desc'); 
       
           if (!empty($search)) {
               $query->where(function ($q) use ($search) {
                   $q->where('title', 'like', "%{$search}%")
                   ->orWhereHas('category', function ($q) use ($search) {
                       $q->where('name', 'like', "%{$search}%");
                   })
                   ->orWhereHas('subCategory', function ($q) use ($search) {
                       $q->where('name', 'like', "%{$search}%");
                   })
                   ->orWhereHas('country', function ($q) use ($search) { 
                       $q->where('name', 'like', "%{$search}%");
                   })
                   ->orWhereHas('city', function ($q) use ($search) {
                       $q->where('name', 'like', "%{$search}%");
                   });
               });
           }
       
           return $query->paginate(10);
   }
     

     //search active jobs from specific recruiter
     public function searchJobs(?string $search = null, int $recruiterId): LengthAwarePaginator
     {
         $query = Job::with(['company','category', 'subCategory', 'country', 'city']) 
                     ->where('valid_until', '>', Carbon::today())
                     ->where('recruiter_id', $recruiterId)
                     ->orderBy('created_at', 'desc'); 
     
         if (!empty($search)) {
             $query->where(function ($q) use ($search) {
                 $q->where('title', 'like', "%{$search}%")
                 ->orWhere('job_world_type', 'like', "%{$search}%") 
                  ->orWhereHas('company', function ($q) use ($search) {
                     $q->where('name', 'like', "%{$search}%");
                 })
                 ->orWhereHas('category', function ($q) use ($search) {
                     $q->where('name', 'like', "%{$search}%");
                 })
                 ->orWhereHas('subCategory', function ($q) use ($search) {
                     $q->where('name', 'like', "%{$search}%");
                 })
                 ->orWhereHas('country', function ($q) use ($search) { 
                     $q->where('name', 'like', "%{$search}%");
                 })
                 ->orWhereHas('city', function ($q) use ($search) { 
                     $q->where('name', 'like', "%{$search}%");
                 });
             });
         }
     
         return $query->paginate(10);
     }

     public function findAllByCompanyIdandRecruterId($companyId, $recruiterId)
     {
        $jobs = Job::where('company_id', $companyId)
        ->where('recruiter_id', $recruiterId)
        ->paginate(6);
        return $jobs;
     }
     
}
