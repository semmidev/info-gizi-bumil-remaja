<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QuizQuestion extends Model
{
    protected $fillable = [
        'type',
        'indicator',
        'text',
        'position',
        'aspect',
        'is_favorable',
        'good_feedback',
        'bad_feedback',
        'explanation',
        'tip',
    ];

    protected function casts(): array
    {
        return [
            'is_favorable' => 'boolean',
        ];
    }

    public function options(): HasMany
    {
        return $this->hasMany(QuizOption::class)->orderBy('position');
    }
}
