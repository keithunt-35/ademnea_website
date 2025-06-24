<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GalleryIntern extends Model
{
    protected $table = 'gallery_interns';

    protected $fillable = ['title', 'venue', 'date', 'description'];

    public function photos(): HasMany
    {
        return $this->hasMany(GalleryPhoto::class, 'gallery_intern_id');
    }
}

