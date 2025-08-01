<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Publication extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'publications';

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
        'name', 
        'title', 
        'publisher', 
        'year', 
        'attachment',
        'image',
        'google_scholar_link'];
    
}
