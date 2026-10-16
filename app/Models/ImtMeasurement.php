<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ImtMeasurement extends Model
{
    protected $fillable = ['user_id', 'weight_kg', 'height_cm', 'bmi', 'measured_at'];

    protected function casts(): array
    {
        return [
            'weight_kg' => 'decimal:1',
            'height_cm' => 'decimal:1',
            'bmi' => 'decimal:1',
            'measured_at' => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Kategori IMT standar WHO untuk dewasa (non-hamil).
     * ponytail: kategori dewasa umum; untuk ibu hamil pakai berat pra-hamil.
     */
    public static function kategori(float $bmi): string
    {
        return match (true) {
            $bmi < 18.5 => 'Kurus (Underweight)',
            $bmi < 25.0 => 'Normal / Ideal',
            $bmi < 30.0 => 'Kelebihan berat badan (Overweight)',
            default => 'Obesitas',
        };
    }
}
