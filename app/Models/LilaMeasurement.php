<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LilaMeasurement extends Model
{
    protected $fillable = ['user_id', 'value_cm', 'measured_at'];

    protected function casts(): array
    {
        return [
            'value_cm' => 'decimal:1',
            'measured_at' => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
