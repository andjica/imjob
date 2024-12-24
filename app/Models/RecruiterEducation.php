<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecruiterEducation extends Model
{
    use HasFactory;
    protected $table = 'recruiter_educations';
    protected $fillable = [
        'recruiter_id',
        'school',
        'degree',
        'field_of_study',
        'year_of_graduation',
        'description',
    ];

    // Relationship to Recruiter
    public function recruiter()
    {
        return $this->belongsTo(Recruiter::class);
    }
}
