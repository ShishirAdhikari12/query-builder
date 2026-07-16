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

    return $actors;
});
