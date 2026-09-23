# Laravel Query Builder, Eloquent, and CRUD Practice with Sakila Database

This project is a hands-on Laravel learning space for working with the Sakila sample database using both the Query Builder and Eloquent ORM. It focuses on writing SQL-style queries in Laravel, understanding relationships, and practicing CRUD operations in a real-world database structure.

The examples in this project are built around the classic Sakila database tables such as `actor`, `film`, `language`, `category`, `country`, `city`, `address`, `staff`, `store`, `customer`, and `payment`.

---

## Project Goal

The main purpose of this project is to practice and understand:

- Query Builder syntax with the `DB` facade
- Eloquent ORM queries and model relationships
- Filtering, sorting, grouping, joining, and subqueries
- CRUD operations in Laravel controllers
- Designing queries using real database tables from Sakila

---

## Tools and Concepts Covered

### 1. Query Builder

Laravel Query Builder allows us to build SQL queries using PHP methods instead of writing raw SQL manually. It is ideal for quick database operations and complex query logic.

Example:

```php
$actors = DB::table('actor')
    ->select(['last_name', DB::raw('count(*) as actor_count')])
    ->groupBy('last_name')
    ->orderBy('actor_count', 'desc')
    ->get();
```

This example demonstrates:

- `select()` to choose columns
- `DB::raw()` for aggregate expressions
- `groupBy()` to group rows
- `orderBy()` to sort results
- `get()` to fetch the results

### 2. Eloquent ORM

Eloquent provides a more model-based approach to database work. Instead of querying tables directly, we work with model classes and relationships.

Example:

```php
$actor = Actor::whereFirstName($first_name)
    ->whereLastName($last_name)
    ->with('films:film_id,title')
    ->firstOrFail();
```

This shows:

- query scope style via model methods
- eager loading with `with()`
- relationship access
- `firstOrFail()` to handle missing records properly

### 3. CRUD Operations

CRUD stands for:

- Create
- Read
- Update
- Delete

This project implements those operations in the controller layer.

---

## Project Structure Highlights

### Models

- `Actor` model
- `Film` model
- `Category` model

The `Actor` model is defined like this:

```php
class Actor extends Model
{
    protected $table = 'actor';
    protected $primaryKey = 'actor_id';

    const CREATED_AT = null;
    const UPDATED_AT = 'last_update';

    protected $fillable = [
        'first_name',
        'last_name',
    ];

    public function films()
    {
        return $this->belongsToMany(Film::class, 'film_actor', 'actor_id', 'film_id');
    }
}
```

This demonstrates:

- table mapping
- primary key configuration
- timestamp handling
- mass assignment protection through `$fillable`
- a many-to-many relationship between actors and films

### Controllers

The controller logic is implemented in:

- `app/Http/Controllers/ActorController.php`
- `app/Http/Controllers/FilmController.php`

These controllers contain query examples for listing, filtering, viewing, creating, updating, and deleting records.

---

## Query Builder Examples Practiced

### 1. Basic filtering

```php
$actors = DB::table('actor')
    ->where('last_name', '=', 'Berry')
    ->get();
```

Or with an array condition:

```php
$actors = DB::table('actor')
    ->where([
        ['last_name', 'Berry'],
        ['first_name', 'Karl']
    ])
    ->get();
```

### 2. Multiple conditions with grouped logic

```php
$actors = DB::table('actor')
    ->where(function ($query) {
        $query->where([
            ['last_name', '=', 'Berry'],
            ['first_name', 'Karl']
        ]);
    })
    ->get();
```

This is useful when you want to group conditions together with logic such as `AND` or `OR`.

### 3. count and group by

```php
$actors = DB::table('actor')
    ->select(['last_name', DB::raw('count(*) as actor_count')])
    ->groupBy('last_name')
    ->orderBy('actor_count', 'desc')
    ->get();
```

This is a common SQL pattern used to count record frequency by category.

### 4. IN queries

```php
$countries = DB::table('country')
    ->select(['country_id', 'country'])
    ->whereIn('country', ['India', 'Nepal', 'China'])
    ->orderBy('country_id', 'desc')
    ->get();
```

### 5. BETWEEN and NOT BETWEEN

```php
$films = DB::table('film')
    ->select(['film_id', 'title', 'special_features', 'replacement_cost'])
    ->whereBetween('replacement_cost', [19.99, 20.99])
    ->orderBy('film_id')
    ->limit(10)
    ->get();
```

```php
$films = DB::table('film')
    ->select(['film_id', 'title', 'special_features', 'replacement_cost'])
    ->whereNotBetween('replacement_cost', [18.99, 20.99])
    ->orderBy('title')
    ->limit(10)
    ->get();
```

### 6. LIKE queries and logical conditions

```php
$films = DB::table('film')
    ->select(['film_id', 'title'])
    ->where('title', 'like', 'K%')
    ->orWhere('title', 'like', 'Q%')
    ->whereIn('language_id', function ($query) {
        $query->select(['language_id'])
            ->from('language')
            ->where('name', 'English');
    })
    ->orderBy('title')
    ->get();
```

This is a good example of composing a conditional search pattern with a subquery.

### 7. Joins

```php
$staffWithAddresses = DB::table('staff AS s')
    ->select([
        's.staff_id',
        's.first_name',
        's.last_name',
        's.email',
        'addr.address',
        'addr.district',
        'addr.postal_code',
        'c.city',
        'cou.country',
    ])
    ->leftJoin('address as addr', 's.address_id', '=', 'addr.address_id')
    ->leftJoin('city as c', 'addr.city_id', '=', 'c.city_id')
    ->leftJoin('country as cou', 'c.country_id', '=', 'cou.country_id')
    ->get();
```

This demonstrates multi-table relationships using left joins.

### 8. Subqueries and derived tables

```php
$sales_details = DB::query()
    ->select('sd.*', 'pd.sales')
    ->fromSub(function ($query) {
        $query->select([
            's.store_id',
            'city.city',
            'count.country',
        ])
            ->from('store as s')
            ->leftJoin('address as a', 's.address_id', '=', 'a.address_id')
            ->join('city', 'a.city_id', '=', 'city.city_id')
            ->join('country as count', 'city.country_id', '=', 'count.country_id');
    }, 'sd')
    ->joinSub(function ($query) {
        $query->select([
            'c.store_id',
            DB::raw('sum(pay.amount) as sales'),
        ])
            ->from('customer as c')
            ->join('payment as pay', 'c.customer_id', '=', 'pay.customer_id')
            ->groupBy('c.store_id');
    }, 'pd', 'sd.store_id', '=', 'pd.store_id')
    ->get();
```

This is especially valuable when combining grouped data from different sources.

---

## Eloquent Examples Practiced

### 1. Listing and filtering with `when()`

```php
$actors = Actor::query()
    ->when(count($parts) >= 2, function ($query) use ($parts) {
        $query->where('first_name', 'like', "%{$parts[0]}%")
            ->where('last_name', 'like', "%{$parts[1]}%");
    })
    ->when(count($parts) === 1 && $parts[0] !== '', function ($query) use ($parts) {
        $query->where(function ($q) use ($parts) {
            $q->where('first_name', 'like', "%{$parts[0]}%")
                ->orWhere('last_name', 'like', "%{$parts[0]}%");
        });
    })
    ->orderBy('actor_id')
    ->paginate(100)
    ->withQueryString();
```

This is a clean way to build conditional filters without repeated `if` blocks.

### 2. Relationship loading

```php
$actor = Actor::whereFirstName($first_name)
    ->whereLastName($last_name)
    ->with('films:film_id,title')
    ->firstOrFail();
```

This loads related film records for an actor efficiently.

### 3. Relationship counting

```php
$actors = Actor::withCount('films')
    ->orderByDesc('films_count')
    ->paginate(100);
```

This helps calculate how many films each actor has.

### 4. Model relationship example

```php
public function films()
{
    return $this->belongsToMany(Film::class, 'film_actor', 'actor_id', 'film_id');
}
```

This defines a many-to-many relationship between `Actor` and `Film` through the `film_actor` pivot table.

---

## CRUD Operations Practiced

### Create

```php
$validated = $request->validate([
    'first_name' => 'required|string|max:50',
    'last_name' => 'required|string|max:50',
]);

Actor::create([
    'first_name' => strtoupper($validated['first_name']),
    'last_name' => strtoupper($validated['last_name']),
]);
```

This validates input and stores a new actor record.

### Read

```php
$actors = Actor::query()->orderBy('actor_id')->paginate(100);
```

Also:

```php
$film = Film::whereTitle($title)
    ->with([
        'language:language_id,name',
        'actors:actor_id,first_name,last_name',
        'categories:category_id,name',
    ])
    ->firstOrFail();
```

### Update

```php
$actor->update([
    'first_name' => strtoupper($validated['first_name']),
    'last_name' => strtoupper($validated['last_name']),
]);
```

This uses route-model binding to fetch the actor and update its information.

### Delete

```php
$actor->delete();
```

This permanently removes the selected actor record.

---

## Example Routes in This Project

The project contains routes for the main purposes of learning and experimentation:

```php
Route::get('/actors', [ActorController::class, 'index'])->name('actor.index');
Route::get('/topActors', [ActorController::class, 'topActors'])->name('actor.top');
Route::get('/showActor/{first_name}/{last_name}', [ActorController::class, 'show'])->name('actor.show');

Route::get('/films', [FilmController::class, 'index'])->name('film.index');
Route::get('/showFilm/{title}', [FilmController::class, 'show'])->name('film.show');
Route::get('/category/{name}', [FilmController::class, 'category'])->name('film.category');
```

These routes demonstrate how data retrieval and presentation are organized in Laravel.

---

## Learning Notes

This project helped build understanding in several major areas:

- SQL logic can be translated into Laravel Query Builder chains
- Eloquent is more expressive and readable when working with models
- Query Builder and Eloquent are both useful depending on the problem
- Relationships such as `belongsToMany` simplify complex data structures
- Joins, subqueries, and aggregate functions are essential for report-style queries
- CRUD should always include validation and safe data handling

---

## Practical Takeaways

Working with the Sakila database in Laravel gives a strong foundation for real database projects because it includes:

- simple tables
- normalized relationships
- many-to-many linkage
- aggregate queries
- data filtering and reporting patterns

This makes Sakila an excellent training database for learning query design and Laravel database handling.

---

## Summary

This project covers the essentials of database work in Laravel:

- Query Builder queries with `DB::table()`
- Eloquent model queries and relation handling
- Joint tables and subqueries
- Filtering, grouping, sorting, and aggregation
- CRUD operations with validation and controller logic

By practicing with the Sakila database, the project strongly reinforces the transition from raw SQL understanding to practical Laravel application development.
