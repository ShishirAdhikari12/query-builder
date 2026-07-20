<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    protected $table = 'film';
    protected $primaryKey = 'film_id';

    const CREATED_AT = null;
    const UPDATED_AT = 'last_update';

    protected $fillable = [
        'title',
        'description',
        'release_year',
        'language_id',
        'original_language_id',
        'rental_duration',
        'rental_rate',
        'length',
        'replacement_cost',
        'rating',
        'special_features',
    ];

    public function actors()
    {
        return $this->belongsToMany(Actor::class, 'film_actor', 'film_id', 'actor_id');
    }

    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id', 'language_id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'film_category', 'film_id', 'category_id');
    }

    public function inventories()
    {
        return $this->hasMany(Inventory::class, 'film_id', 'film_id');
    }

    public function filmText()
    {
        return $this->hasOne(FilmText::class, 'film_id', 'film_id');
    }

}
