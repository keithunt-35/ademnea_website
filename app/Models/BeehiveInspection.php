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
    'beekeeper_name',
    'date',
    'apiary_location',
    'weather_conditions',
    'hive_id',
    'hive_type',
    'hive_condition',
    'presence_of_queen',
    'queen_cells_present',
    'brood_pattern',
    'eggs_and_larvae_present',
    'honey_stores',
    'pollen_stores',
    'bee_population',
    'aggressiveness_of_bees',
    'diseases_or_pests_observed',
    'disease_details',
    'presence_of_beetles',
    'presence_of_other_pests',
    'other_pests_details',
    'frames_checked',
    'any_frames_replaced',
    'hive_cleaned',
    'supers_added_or_removed',
    'any_other_actions_taken',
    'comments_and_recommendations',
    'inspected_by',
    'signature',
];



    // Optional: Define relationships, custom methods, etc.
}

