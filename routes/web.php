<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

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


    return $films;
    
});
