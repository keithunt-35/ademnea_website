<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GalleryPhoto extends Model
{
    protected $fillable = ['gallery_intern_id', 'photo_path'];

    public function gallery(): BelongsTo
    {
        return $this->belongsTo(GalleryIntern::class, 'gallery_intern_id');
    }
}


