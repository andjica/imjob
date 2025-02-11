<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use App\Events\NewFollowNotification;

class CompanyRecruiter extends Pivot
{
    protected $table = 'company_recruiter';

    protected $fillable = ['recruiter_id', 'company_id', 'from_date', 'until_date', 'status'];

    public $timestamps = true; // Ensure timestamps are enabled if the pivot table uses them.

    // Example: Add a scope to query active relationships
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    // Example: Add a scope to query past relationships
    public function scopePast($query)
    {
        return $query->where('status', 'past');
    }

    public function getStatusAttribute($value)
    {
        if ($value === 'onpending') {
            return 'onpending';
        }

        if ($this->until_date === null || $this->until_date->isFuture()) {
            return 'active';
        }

        return 'past';
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    protected static function booted()
    {
        static::created(function ($follow) {
            $companyToFollow = Company::find($follow->company_id);
            $follower = Recruiter::find($follow->recruiter_id);

            if ($companyToFollow && $follower) {
                broadcast(new NewFollowNotification($companyToFollow, $follower));
            }
        });
    }
   
}
