<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class ContentImage extends Model
{
    protected $fillable = [
        'content_id',
        'image',
        'position',
    ];

    public function content(): BelongsTo
    {
        return $this->belongsTo(Content::class);
    }

    public function imageUrl(): string
    {
        return Storage::url($this->image);
    }
}
