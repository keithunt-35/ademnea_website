<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HiveEntranceBeeCount extends Model
{
    use HasFactory;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'hive_entrance_bee_counts';

    /**
     * The database primary key value.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['detected_bees', 'hive_id'];

    /**
     * Get the hive that owns the bee count at the entrance.
     */
    public function hive()
    {
        return $this->belongsTo(Hive::class);
    }
}