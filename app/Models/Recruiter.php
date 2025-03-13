<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property Collection<int, Company> $companies
 * @property Company $company
 */
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


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }

    //if you want active and inactive companies which recruiter works and wokrking
    public function companies(): BelongsToMany
    {
        return $this->belongsToMany(Company::class, 'company_recruiter')
                    ->withPivot('from_date', 'until_date', 'status')
                    ->using(CompanyRecruiter::class);
    }

    //working now for that companies
    public static function activeCompanies(): BelongsToMany
    {
        return $this->belongsToMany(Company::class)
        ->withPivot(['from_date', 'until_date'])
        ->wherePivot('status', 'Active')
        ->where(function ($query) {
            $query->whereNull('until_date')
                  ->orWhere('until_date', '>', now());

        });

    }

    //working in the pass :)
    public function inactiveCompanies(): BelongsToMany
    {
        return $this->belongsToMany(Company::class)
        ->withPivot(['from_date', 'until_date', 'status'])
        ->wherePivot('status', 'past')
        ->where(function ($query) {
            $query->whereNotNull('until_date') // Include rows with `until_date` set
                  ->orWhere('until_date', '<=', now()); // Include past companies
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function subCategory(): BelongsTo
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function freelancerCompany(): HasOne
    {
        return $this->hasOne(FreelancerCompany::class, 'freelancer_id');
    }

    public function education(): HasOne
    {
        return $this->hasOne(RecruiterEducation::class, 'recruiter_id');
    }

    public function contributors(): BelongsToMany
    {
        return $this->belongsToMany(Contributor::class, 'contributor_recruiter', 'recruiter_id', 'contributor_id')
                    ->withPivot('status', 'invite_type', 'from_date', 'until_date')
                    ->withTimestamps();
    }

    public function jobs()
    {
        return $this->hasMany(Job::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }
}
