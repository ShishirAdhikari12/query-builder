<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $table = 'inventory';
    protected $primaryKey = 'inventory_id';

    const CREATED_AT = null;
    const UPDATED_AT = 'last_update';

    protected $fillable = [
        'film_id',
        'store_id',
    ];

    public function film()
    {
        return $this->belongsTo(Film::class, 'film_id', 'film_id');
    }

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id', 'store_id');
    }

    public function rentals()
    {
        return $this->hasMany(Rental::class, 'inventory_id', 'inventory_id');
    }
}
