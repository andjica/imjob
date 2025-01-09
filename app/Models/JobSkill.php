<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $skill
 * @property bool $is_required
 * @property Job $job
 */
class JobSkill extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_id',
        'skill',
        'is_required',
    ];

    public function job(): BelongsTo
    {
        return $this->belongsTo(Job::class);
    }
}
