<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $table = 'language';
    protected $primaryKey = 'language_id';

    const CREATED_AT = null;
    const UPDATED_AT = 'last_update';

    public function films()
    {
        return $this->hasMany(Film::class, 'language_id', 'language_id');
    }
}
