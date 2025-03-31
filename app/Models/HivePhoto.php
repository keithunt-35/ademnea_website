<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HivePhoto extends Model
{
    use HasFactory;
    protected $fillable = [
        'hive_id',
        'path',
        'detected_bees',
    ];


    protected static function boot()
      {
          parent::boot();

          static::creating(function ($photo) {
              // Check if a photo with the same path and hive_id already exists
              $exists = self::where('hive_id', $photo->hive_id)
                            ->where('path', $photo->path)
                            ->exists();

              if ($exists) {
                  return false;
              }
          });
      }


    /**
     * Get the hive that owns the photo.
     */
    public function hive()
    {
        return $this->belongsTo(Hive::class);
    }
}
