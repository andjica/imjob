<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Collection;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @property int $id
 * @property int $role_id
 * @property ?string $companyType
 * @property ?Company $company
 * @property ?Recruiter $recruiter
 * @property string $first_name
 * @property string $last_name
 */
class User extends Authenticatable implements JWTSubject, MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'first_name',
        'last_name',
        'email',
        'password',
        'google_id',
        'role_id',
        'verification_code',
        'verification_expires_at',
        'is_mobile_verified'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function company(): HasOne
    {
        return $this->hasOne(Company::class, 'user_id');
    }

    public function recruiter(): HasOne
    {
        return $this->hasOne(Recruiter::class, 'user_id');
    }

    public function contributor(): HasOne
    {
        return $this->hasOne(Contributor::class);
    }

    public function getFirstName(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function messagesSent()
    {
        return $this->hasMany(Message::class, 'user_id');
    }

    public function messagesReceived()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    // Sve poruke u kojima je ovaj user (bilo kao sender ili receiver)
    public function allMessages()
    {
        return \App\Models\Message::where('user_id', $this->id)
            ->orWhere('receiver_id', $this->id);
    }

    public function candidateProfile()
    {
        return $this->hasOne(CandidatProfile::class);
    }
}
