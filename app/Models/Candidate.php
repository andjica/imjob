<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

/**
 * @property int $id
 * @property int $job_id
 * @property int $user_id
 * @property string|null $current_job_title
 * @property string|null $company
 * @property int $years_of_experience
 * @property string $phone
 * @property string $country
 * @property string $city
 * @property string $status
 * @property Job $job
 * @property RecruitmentProcess|null $recruitmentProcess
 */
class Candidate extends Model
{
    use HasFactory;

    public const STATUS_ACCEPT = 'accept';
    public const STATUS_REJECTED = 'reject';
    public const STATUS_PENDING = 'pending';

    protected $fillable = [
        'job_id',
        'user_id',
        'current_job_title',
        'company',
        'years_of_experience',
        'phone',
        'country',
        'city',
        'status'
    ];

    public function job(): BelongsTo
    {
        return $this->belongsTo(Job::class, 'job_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function recruitmentProcess(): HasOne
    {
        return $this->hasOne(RecruitmentProcess::class);
    }

    public function recruitmentSubPhase()
    {
        return $this->hasMany(RecruitmentSubphase::class);
    }

    public function recruitmentSubPhases(): HasManyThrough
    {
        return $this->hasManyThrough(
            RecruitmentSubphase::class, // Final table (subphases)
            RecruitmentProcess::class,  // Intermediate table (recruitment process)
            'candidate_id',             // Foreign key on recruitment_processes
            'recruitment_process_id',   // Foreign key on recruitment_subphases
            'id',                       // Local key on candidates
            'id'                        // Local key on recruitment_processes
        );
    }
}
