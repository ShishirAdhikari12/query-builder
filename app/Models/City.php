<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'city';
    protected $primaryKey = 'city_id';

    const CREATED_AT = null;
    const UPDATED_AT = 'last_update';

    protected $fillable = [
        'city',
        'country_id',
    ];

    public function address()
    {
        return $this->hasMany(Address::class, 'city_id', 'city_id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id', 'country_id');
    }
}
