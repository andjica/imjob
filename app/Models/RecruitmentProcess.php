<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $job_application_id
 * @property string $current_phase
 */
class RecruitmentProcess extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_application_id',
        'current_phase'
    ];
}
