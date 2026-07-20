<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $table = 'store';
    protected $primaryKey = 'store_id';

    const CREATED_AT = null;
    const UPDATED_AT = 'last_update';

    protected $fillable = [
        'manager_staff_id',
        'address_id',
    ];

    public function address()
    {
        return $this->belongsTo(Address::class, 'address_id', 'address_id');
    }

    public function customers()
    {
        return $this->hasMany(Customer::class, 'store_id', 'store_id');
    }

    public function inventory()
    {
        return $this->hasMany(Inventory::class, 'store_id', 'store_id');
    }

    public function staff()
    {
        return $this->hasMany(Staff::class, 'store_id', 'store_id');
    }

    public function manager()
    {
        return $this->belongsTo(Staff::class, 'manager_staff_id', 'staff_id');
    }

    public function films()
    {
        return $this->hasManyThrough(Film::class, Inventory::class, 'store_id', 'film_id', 'store_id', 'film_id');
    }

    public function rentals()
    {
        return $this->hasManyThrough(Rental::class, Inventory::class, 'store_id', 'inventory_id', 'store_id', 'inventory_id');
    }

    public function payments()
    {
        return $this->hasManyThrough(Payment::class, Rental::class, 'store_id', 'rental_id', 'store_id', 'rental_id');
    }

}
