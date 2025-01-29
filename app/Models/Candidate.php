<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

    public const STATUS_ACTIVE = 'active';
    public const STATUS_REJECTED = 'rejected';
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
        return $this->belongsTo(Job::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function recruitmentProcess(): HasOne
    {
        return $this->hasOne(RecruitmentProcess::class);
    }
}
