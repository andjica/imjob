<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $job_application_id
 * @property string $current_phase
 */
class RecruitmentProcess extends Model
{
    use HasFactory;

    public const APPLICATION_RECEIVED = "application_received";
    public const SELECTION = "selection";
    public const PREPARATION = "preparation";
    public const TRANSFER = "transfer";
    public const OFFER_STAGE = "offer_stage";

    
    protected $fillable = [
        'current_phase',
        'candidate_id',
        // 'job_application_id',
        'current_phase'
    ];
    public function subphases(): HasMany
    {
        return $this->hasMany(RecruitmentSubphase::class);
    }
}
