<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DailyTargetLog extends Model
{
    protected $fillable = ['user_id', 'log_date', 'checklist_item_id', 'is_done'];

    protected function casts(): array
    {
        return [
            'log_date' => 'date',
            'is_done' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function checklistItem(): BelongsTo
    {
        return $this->belongsTo(ChecklistItem::class);
    }
}
