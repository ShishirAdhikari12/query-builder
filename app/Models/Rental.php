<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    protected $table = 'rental';
    protected $primaryKey = 'rental_id';

    const CREATED_AT = 'rental_date';
    const UPDATED_AT = 'last_update';

    protected $fillable = [
        'rental_date',
        'inventory_id',
        'customer_id',
        'return_date',
        'staff_id',
    ];

    public function inventory()
    {
        return $this->belongsTo(Inventory::class, 'inventory_id', 'inventory_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'customer_id');
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id', 'staff_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'rental_id', 'rental_id');
    }
}
