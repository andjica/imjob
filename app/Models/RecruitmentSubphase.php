<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $recruitment_process_id
 * @property string $phase
 * @property string $subphase
 * @property DateTime|null $scheduled_at
 * @property string|null $meeting_link
 * @property string|null $meeting_title
 * @property string|null $description
 * @property bool $completed
 * @property string|null $feedback
 */
class RecruitmentSubphase extends Model
{
    use HasFactory;

    protected $fillable = [
        'recruitment_process_id',
        'phase',
        'subphase',
        'scheduled_at',
        'meeting_link',
        'meeting_title',
        'description',
        'completed',
        'feedback',
        'available_subphase_id',
    ];

    public function availableSubphase(): BelongsTo
    {
        return $this->belongsTo(AvailableRecruitmentSubphases::class, 'available_subphase_id');
    }
}
