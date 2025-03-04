<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use App\Events\NewFollowNotification;

class CompanyRecruiter extends Pivot
{
    protected $table = 'company_recruiter';

    protected $fillable = ['recruiter_id', 'company_id', 'from_date', 'until_date', 'status', 'invite_type'];

    public $timestamps = true; // Ensure timestamps are enabled if the pivot table uses them.

    // Example: Add a scope to query active relationships
    public function scopeActive($query)
    {
        return $query->where('status', 'Active');
    }

    // Example: Add a scope to query past relationships
    public function scopePast($query)
    {
        return $query->where('status', 'Past');
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
        return $this->belongsTo(Company::class, 'company_id');
    }

    // protected static function booted()
    // {
    //     static::created(function ($follow) {
    //         $companyToFollow = Company::find($follow->company_id);
    //         $follower = Recruiter::find($follow->recruiter_id);

    //         if ($companyToFollow && $follower) {
    //             broadcast(new NewFollowNotification($companyToFollow, $follower));
    //         }
    //     });
    // }

    //if company send to recruiter follow request
    public static function getCompaniesFollowRequest()
    {
        $recruiterId = auth()->user()->recruiter->id;
        return self::where('recruiter_id', $recruiterId)
        ->where('status', 'Pending')
        ->where('invite_type', 'Company')->get();
    }

    //if recruiter send company follow request
    public static function getRecruiterFollowRequestToCompanies()
    {
        $recruiterId = auth()->user()->recruiter->id;
        return self::where('recruiter_id', $recruiterId)
        ->where('status', 'Pending')
        ->where('invite_type', 'Recruiter')->get();
    }

    //all connections recruiter - companies
    public function getAllConnections()
    {
        $recruiterId = auth()->user()->recruiter->id;
        return self::where('recruiter_id', $recruiterId)
        ->where('status', 'Active')
        ->get();
    
    }


   
}
