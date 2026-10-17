<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'username',
        'full_name',
        'age',
        'address',
        'religion',
        'pregnancy_month',
        'password',
        'role',
        'bidan_phone',
        'last_login_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'last_login_at' => 'datetime',
        ];
    }

    public function dailyTargetLogs(): HasMany
    {
        return $this->hasMany(DailyTargetLog::class);
    }

    public function needsProfileCompletion(): bool
    {
        return $this->role !== 'admin'
            && (! trim((string) $this->full_name) || ! $this->age || ! trim((string) $this->address));
    }

    public function logoPath(): string
    {
        return 'logo/logo.png';
    }

    public function quizAttempts(): HasMany
    {
        return $this->hasMany(QuizAttempt::class);
    }

    public function lilaMeasurements(): HasMany
    {
        return $this->hasMany(LilaMeasurement::class);
    }

    public function imtMeasurements(): HasMany
    {
        return $this->hasMany(ImtMeasurement::class);
    }

    public function activityLogs(): HasMany
    {
        return $this->hasMany(ActivityLog::class);
    }
}
