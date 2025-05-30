<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CandidatProfile extends Model
{
    protected $table = 'candidates';

    protected $fillable = [
        'user_id',
        'country_id',
        'city_id',
        'phone',
        'profile_image',
        'birthday',
        'current_company',
        'current_title_job',
        'years_of_experience',
        'cv',
        'school_name',
        'school_degree',
        'school_year_start',
        'school_year_end',
        'is_finished_profile'
    ];

    /**
     * Veza sa korisnikom (user)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Veza sa državom (country)
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Veza sa gradom (city)
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Veza sa pivot tabelom candidate_job (prijave kandidata)
     */
    public function applications(): HasMany
    {
        return $this->hasMany(Candidate::class, 'candidate_id');
    }

    /**
     * Veza sa poslovima kroz pivot tabelu candidate_job
     */
    public function jobs(): BelongsToMany
    {
        return $this->belongsToMany(Job::class, 'candidate_job', 'candidate_id', 'job_id')
                    ->withPivot('status', 'applied_at')
                    ->withTimestamps();
    }

    public function job()
    {
        return $this->belongsTo(Job::class);
    }
}
