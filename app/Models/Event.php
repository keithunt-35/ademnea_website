<?php

// app/Models/Event.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'title',
        'venue',
        'description',
        'date',
        'article_link',
    ];


public function photos()
{
    return $this->hasMany(\App\Models\EventPhoto::class);
}
}

