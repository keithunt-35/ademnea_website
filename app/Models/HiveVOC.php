<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HiveVOC extends Model
{
    protected $table = 'hive_vocs';

    protected $fillable = [
        'hive_id',
        'record',
        'created_at',
    ];
}
