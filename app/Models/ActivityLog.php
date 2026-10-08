<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{
    protected $fillable = ['user_id', 'device_id', 'event', 'description', 'duration_seconds'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
