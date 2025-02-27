<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
}
