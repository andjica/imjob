<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AiSearchHistory extends Model
{
    protected $fillable = [
        'user_id', 'user_message', 'ai_response',
        'jobs', 'filters_used', 'language_code'
    ];

    protected $casts = [
        'jobs' => 'array',
        'filters_used' => 'array',
    ];
}
