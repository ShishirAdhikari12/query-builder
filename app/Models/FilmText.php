<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FilmText extends Model
{
    protected $table = 'film_text';
    protected $primaryKey = 'film_id';

    const CREATED_AT = null;
    const UPDATED_AT = null;

    protected $fillable = [
        'title',
        'description',
    ];

    
}
