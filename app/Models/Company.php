<?php

namespace App\Models;




use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $id
 * @property User $user
 * @property Category $category
 */
class Company extends Model
{
    use HasFactory;

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function subCategory(): BelongsTo
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function recruiters(): BelongsToMany
    {
        return $this->belongsToMany(Recruiter::class, 'company_recruiter')
        ->using(CompanyRecruiter::class) // Specify the custom pivot model
        ->withPivot('from_date', 'until_date', 'status')
        ->withTimestamps();
    }

    public function recruitersCount(): int
    {
        return $this->belongsToMany(Recruiter::class, 'company_recruiter')
            ->using(CompanyRecruiter::class)
            ->withPivot('from_date', 'until_date', 'status')
            ->wherePivot('status', 'Active') // Ensure only active recruiters are counted
            ->count();
    }
    //if user is freelancer he needs to have only one company
    public function freelancerCompany(): HasOne
    {
        return $this->hasOne(FreelancerCompany::class, 'company_id');
    }

    public function companyType(): BelongsTo
    {
        return $this->belongsTo(CompanyType::class, 'company_type_id');
    }

    public function getRouteKeyName(): string
    {
        return 'id';
    }

     //if company send to recruiter follow request
    public function pendingRecruiters()
    {
        return $this->belongsToMany(Recruiter::class, 'company_recruiter', 'company_id', 'recruiter_id')
                    ->wherePivot('status', 'Pending');
    }

    public function activeRecruiters()
    {
        return $this->belongsToMany(Recruiter::class, 'company_recruiter', 'company_id', 'recruiter_id')
        ->wherePivot('status', 'Active');
    }
}
