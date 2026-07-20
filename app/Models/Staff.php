<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $table = 'staff';
    protected $primaryKey = 'staff_id';

    const CREATED_AT = null;
    const UPDATED_AT = 'last_update';

    protected $fillable = [
        'first_name',
        'last_name',
        'address_id',
        'email',
        'store_id',
        'active',
        'username',
        'password',
        'picture',
    ];

    public function address()
    {
        return $this->belongsTo(Address::class, 'address_id', 'address_id');
    }

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id', 'store_id');
    }

    public function rentals()
    {
        return $this->hasMany(Rental::class, 'staff_id', 'staff_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'staff_id', 'staff_id');
    }

}
