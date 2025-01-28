<?php

namespace App\Models;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @method static static create(array $data)
 * @property int $id
 * @property Collection<int, JobSkill> $skills
 */
class Job extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'job_world_type',
        'recruiter_id',
        'category_id',
        'sub_category_id',
        'country_id',
        'city_id',
        'job_type_id',
        'title',
        'description',
        'salary_min',
        'salary_max',
        'experience_level',
        'min_age',
        'max_age',
        'special_requirements',
        'valid_until',
    ];

    public function skills(): HasMany
    {
        return $this->hasMany(JobSkill::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function recruiter(): BelongsTo
    {
        return $this->belongsTo(Recruiter::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function subCategory(): BelongsTo
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function jobType(): BelongsTo
    {
        return $this->belongsTo(JobType::class);
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

   


   
}
