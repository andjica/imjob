<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ContributorRecruiter extends Pivot
{
    public const PENDING = 'pending';
    public const REJECTED = 'rejected';

    public const ACTIVE = 'active';

    protected $table = 'contributor_recruiter';

    protected $fillable = ['recruiter_id', 'contributor_id', 'from_date', 'until_date', 'status', 'invite_type'];

    public $timestamps = true;

    public function recruiter(): BelongsTo
    {
        return $this->belongsTo(Recruiter::class, 'recruiter_id');
    }

    public function contributor(): BelongsTo
    {
        return $this->belongsTo(Contributor::class, 'contributor_id');
    }
}
