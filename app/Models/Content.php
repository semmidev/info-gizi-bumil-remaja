<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Content extends Model
{
    protected $fillable = [
        'content_category_id',
        'position',
        'title',
        'description',
        'cover',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(ContentCategory::class, 'content_category_id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(ContentImage::class)->orderBy('position');
    }

    public function coverUrl(): ?string
    {
        return $this->cover ? Storage::url($this->cover) : null;
    }
}
