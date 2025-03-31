<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BatteryReading extends Model
{
    use HasFactory;

    protected $fillable = ['entry_id', 'voltage', 'battery_percentage', 'created_at'];

    public $timestamps = false; // Since ThingSpeak provides timestamps
}

