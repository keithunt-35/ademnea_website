<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BeehiveInspection extends Model
{
    use HasFactory;

    // The table associated with the model
    protected $table = 'beehive_inspections';

    // The attributes that are mass assignable
// In BeehiveInspection model
protected $fillable = [
    'hiveId',
    'inspection_date',
    'inspector_name',
    'weather_conditions',

    // Hive Info
    'hive_type',
    'hive_condition',
    'queen_presence',
    'queen_cells',
    'brood_pattern',
    'eggs_larvae',
    'honey_stores',
    'pollen_stores',

    // Colony Health
    'bee_population',
    'aggressiveness',
    'diseases_observed',
    'diseases_specify',
    'pests_present',

    // Maintenance
    'frames_checked',
    'frames_replaced',
    'hive_cleaned',
    'supers_changed',
    'other_actions',

    // Comments
    'comments',
];





    // Optional: Define relationships, custom methods, etc.

    public function hive()
{
    return $this->belongsTo(Hive::class);
}
}

