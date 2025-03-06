<?php

namespace App\Models;

use App\Models\Recruiter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Contributor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'user_id',
        'contributor_type_id',
        'custom_contributor_type',
        'country_id',
        'city_id',
        
    ];
  
    public function contributorType()
    {
        return $this->belongsTo(ContributorType::class, 'contributor_type_id');
    }
    
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

   
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function recruiters(): BelongsToMany
    {
        return $this->belongsToMany(Recruiter::class, 'contributor_recruiter', 'contributor_id', 'recruiter_id')
                    ->withPivot('status', 'from_date', 'until_date')
                    ->using(ContributorRecruiter::class)
                    ->withTimestamps();
    }
}
