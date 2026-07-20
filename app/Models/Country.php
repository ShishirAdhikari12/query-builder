<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $table = 'country';
    protected $primaryKey = 'country_id';

    const CREATED_AT = null;
    const UPDATED_AT = 'last_update';

    protected $fillable = [
        'country',
    ];

    public function cities()
    {
        return $this->hasMany(City::class, 'country_id', 'country_id');
    }
}
