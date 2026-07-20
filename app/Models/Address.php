<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'address';
    protected $primaryKey = 'address_id';

    const CREATED_AT = null;
    const UPDATED_AT = 'last_update';

    protected $fillable = [
        'address',
        'address2',
        'district',
        'city_id',
        'postal_code',
        'phone',
    ];  

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'city_id');
    }

    public function country()
    {
        return $this->hasOneThrough(Country::class, City::class, 'city_id', 'country_id', 'city_id', 'country_id');
    }

    public function customers()
    {
        return $this->hasMany(Customer::class, 'address_id', 'address_id');
    }

    public function stores()
    {
        return $this->hasMany(Store::class, 'address_id', 'address_id');
    }

    public function staff()
    {
        return $this->hasMany(Staff::class, 'address_id', 'address_id');
    }

}
