<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
 */
class Candidate extends Model
{
    use HasFactory;

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
}
