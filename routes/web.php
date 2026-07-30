<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ActorController;
use App\Models\Actor;

Route::get('/', function () {

    /* 
    select * from actor 
    where last_name = 'Berry'
    */

    // $actors = DB::table('actor')
    //     ->where('last_name', '=', 'Berry')
    //     ->where('first_name', 'Karl')
    //     ->get();

    // $actors = DB::table('actor')
    //     ->where([
    //         ['last_name', 'Berry'],
    //         ['first_name', 'Karl']
    //     ])
    //     ->get();

    // $actors = DB::table('actor')
    //     ->where(function ($query) {
    //         $query->where([
    //             ['last_name', '=', 'Berry'],
    //             ['first_name', 'Karl']
    //         ]);
    //     })
    //     ->get();

    // ----------------------------------------------------------------------------------------------------------
    # list the last names of actors, count the number of times last name is being shared
    /* 
    select last_name, count(*) as actor_count
    from actor
    group by last_name
    order by actor_count desc
    */


    $actors = DB::table('actor')
        ->select(['last_name', DB::raw('count(*) as actor_count')])
        ->groupBy('last_name')
        ->orderBy('actor_count', 'desc')
        ->get();

    // ------------------------------------------------------------------------------------------------------

    /*     select country_id, country
    from country
    where country in ('India', 'Nepal', 'China')
    order by country_id desc */

    $countries = DB::table('country')
        ->select(['country_id', 'country'])
        ->whereIn('country', ['India', 'Nepal', 'China'])
        ->orderBy('country_id', 'desc')
        ->get();

    // -----------------------------------------------------------------------------------------------------------------------

    /* select film_id, title, special_features, replacement_cost   from film
    where replacement_cost between 19.99 and 20.99
    order by film_id
    limit 10 */

    // $films = DB::table('film')
    //     ->select(['film_id', 'title', 'special_features', 'replacement_cost'])
    //     ->whereBetween('replacement_cost', [19.99, 20.99])
    //     ->orderBy('film_id')
    //     ->limit(10)
    //     ->get();

    // -----------------------------------------------------------------------------------------------------------------------

    /* select film_id, title, special_features, replacement_cost   from film
    where replacement_cost not between 18.99 and 20.99
    order by film_id
    limit 10 */

    $films = DB::table('film')
        ->select(['film_id', 'title', 'special_features', 'replacement_cost'])
        ->whereNotBetween('replacement_cost', [18.99, 20.99])
        ->orderBy('title')
        ->limit(10)
        ->get();

    $films = DB::table('film')
        ->select(['film_id', 'title', 'special_features', 'replacement_cost'])
        ->where('title', 'African Egg')
        ->orWhere('title', 'Agent Truman')
        ->orWhereIn('film_id', [1, 2, 3])
        ->orderBy('film_id')
        ->get();

    // -----------------------------------------------------------------------------------------------------------------------
    /* 
    select 
    s.staff_id, s.first_name, s.last_name, s.email,
    addr.address, addr.district, addr.postal_code,
    c.city, cou.country 
    from staff as s
    left join address as addr
    on s.address_id = addr.address_id
    left join city as c
    on addr.city_id = c.city_id 
    left join country as cou
    on c.country_id = cou.country_id 
    */


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

    // -----------------------------------------------------------------------------------------------------------------------

    /* 
    #display the titles of movies starting with the letters K and Q whose language is English (You are only allowed to use subqueries)

    using join-------------
    select f.film_id, f.title, l.name 
    from film f 
    join `language` l 
    on f.language_id = l.language_id 
    where l.name = 'English'
    and f.title like 'K%'
    or f.title like 'Q%'


 */
    // ----MY SOLUTION---
    $films = DB::table('film as f')
        ->select(['f.film_id', 'f.title'])
        ->join('language as l', 'f.language_id', '=', 'l.language_id')
        ->where('l.name', 'English')
        ->where(function ($query) {
            $query->where('f.title', 'like', 'K%')
                ->orWhere('f.title', 'like', 'Q%');
        })
        ->get();
    // ---------------------------------------------------------------
    /* select film_id, title
    from film
    where title like 'K%' or title like 'Q%'
    and language_id in (
        select language_id 
        from language
        where name = 'English'
    )
    order by title */

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

    //---------------------------------------------------------------------------------------------
    /* #write a query to display each store's id, city, country and sales they have made.
    # store->left join ->address
    # address->inner join -> city
    # city->inner join ->country     ===> store id   // store details

    # customer-> inner join ->payment  ===> store id //payment details

    select store_details.*, payment_details.sales 
    from(
        select s.store_id, city.city, count.country 
        from store as s
        left join address a 
        on s.address_id = a.address_id
        join city
        on a.city_id = city.city_id 
        join country as count
        on city.country_id = count.country_id 
    ) as store_details
    join (
        select c.store_id, sum(pay.amount ) as sales
        from customer as c 
        inner join payment as pay
        on c.customer_id = pay.customer_id
        group by c.store_id
        
    ) as payment_details
    on store_details.store_id = payment_details.store_id
    order by store_details.store_id  */

    $store_details = DB::query()
        ->select([
            's.store_id',
            'city.city',
            'count.country',
        ])
        ->from('store as s')
        ->leftJoin('address as a', 's.address_id', '=', 'a.address_id')
        ->join('city', 'a.city_id', '=', 'city.city_id')
        ->join('country as count', 'city.country_id', '=', 'count.country_id');

    $payment_details = DB::query()
        ->select([
            'c.store_id',
            DB::raw('sum(pay.amount) as sales'),
        ])
        ->from('customer as c')
        ->join('payment as pay', 'c.customer_id', '=', 'pay.customer_id')
        ->groupBy('c.store_id');

    $sales_details = DB::query()
        ->select('sd.*', 'pd.sales')
        ->fromSub($store_details, 'sd')
        ->joinSub($payment_details, 'pd', 'sd.store_id', '=', 'pd.store_id')
        ->get();

    // another way of writing
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

    //------------------------------------------------------------------------------------

    /*
    # display categories and number of films in each category where films language is english

    #category -> left join -> film_category
    # film_category -> inner join -> film
    # fiml -> inner join -> language

    select cat.name, count(f.film_id) as film_count
    from category as cat
    left join film_category as fc
    on cat.category_id = fc.category_id 
    join film as f 
    on fc.film_id = f.film_id 
    join language as lang
    on f.language_id = lang.language_id 
    where lang.name = 'English'
    group by cat.name 
    order by film_count desc
    */

    //--------  MY SOLUTION ---------
    // $categories = DB::query()
    //     ->select('cat.name', DB::raw('count(f.film_id) as film_count'))
    //     ->from('category', 'cat')
    //     ->leftJoin('film_category as fc', 'cat.category_id', '=', 'fc.category_id')
    //     ->join('film as f', 'fc.film_id', '=', 'f.film_id')
    //     ->join('language as lang', 'f.language_id', '=', 'lang.language_id')
    //     ->where('lang.name', '=', 'English')
    //     ->groupBy('cat.name')
    //     ->orderBy('film_count', 'desc')->get();

    $categories = DB::query()
        ->select('cat.name', DB::raw('count(f.film_id) as film_count'))
        ->from('category as cat')
        ->leftJoin('film_category as fc', 'cat.category_id', '=', 'fc.category_id')
        ->join('film as f', 'fc.film_id', '=', 'f.film_id')
        ->join('language as lang', function ($join) {
            $join->on('f.language_id', '=', 'lang.language_id')
                ->where('lang.name', 'English');
        })
        ->groupBy('cat.name')
        ->orderBy('film_count', 'desc')->get();


    return view('home');
})->name('home');

Route::get('/actors', [ActorController::class, 'index'])->name('actor.index');

Route::get('/createActor', [ActorController::class, 'create'])->name('actor.create');
Route::put('/createActor', [ActorController::class, 'store'])->name('actor.store');
Route::get('/editActor/{actor}', [ActorController::class, 'edit'])->name('actor.edit');
Route::put('/editActor/{actor}', [ActorController::class, 'update'])->name('actor.update');
Route::get('/deletActor/{actor}', [ActorController::class, 'destroy'])->name('actor.delete');
