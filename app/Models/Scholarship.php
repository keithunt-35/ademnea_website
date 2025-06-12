<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Scholarship extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'scholarships';

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
    protected $fillable = [
        'title',
        'description',
        'instructions',
        // add other columns here if still exist like task, topic, deliverables, competence, positions
    ];
}
