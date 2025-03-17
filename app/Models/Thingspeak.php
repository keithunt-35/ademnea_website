<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thingspeak extends Model
{
    use HasFactory;
    protected $fillable = ['hive_id', 'channel_id', 'read_api_key', ];
    protected $casts = [
        'measured_at' => 'datetime',
    ];

    public function hive(){
        return $this->belongsTo(Hive::class);
    }
}
