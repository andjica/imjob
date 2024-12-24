<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FreelancerCompany extends Model
{
    use HasFactory;

    // Define fillable fields for mass assignment protection
    protected $fillable = [
        'freelancer_id',
        'company_id',
    ];

    /**
     * Relationship to Recruiter (freelancer).
     */
    public function recruiter()
    {
        return $this->belongsTo(Recruiter::class, 'freelancer_id');
    }

    /**
     * Relationship to Company.
     */
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

}
