<?php

namespace App\Models;

use App\Models\CompanyRecruiter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Recruiter extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'company_id',
        'profile_image',
        'birthday',
        'title_function',
        'experience_level',
        'availability',
        'phone_number'
    ];

   
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //if you want active and inactive companies which recruiter works and wokrking
    public function companies()
    {
        return $this->belongsToMany(Company::class, 'company_recruiter')
                    ->withPivot('from_date', 'until_date', 'status')
                    ->using(CompanyRecruiter::class);
    }

    //working now for that companies
    public function activeCompanies()
    {
        return $this->belongsToMany(Company::class)
        ->withPivot(['from_date', 'until_date'])
        ->where(function ($query) {
            $query->whereNull('until_date')
                  ->orWhere('until_date', '>', now());
                  
        });
        
    }

    //working in the pass :)
    public function inactiveCompanies()
    {
        return $this->belongsToMany(Company::class)
        ->withPivot(['from_date', 'until_date', 'status'])
        ->wherePivot('status', 'past')
        ->where(function ($query) {
            $query->whereNotNull('until_date') // Include rows with `until_date` set
                  ->orWhere('until_date', '<=', now()); // Include past companies
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function freelancerCompany()
    {
        return $this->hasOne(FreelancerCompany::class, 'freelancer_id');
    }

    public function education()
    {
        return $this->hasOne(RecruiterEducation::class, 'recruiter_id');
    }

    
}
