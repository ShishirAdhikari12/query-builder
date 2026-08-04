<?php

namespace App\Http\Controllers;

use App\Models\Film;
use Illuminate\Http\Request;

class FilmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(request $request)
    {
        // $films = Film::select('film_id', 'title')
        //     ->Paginate(100);

        $films = Film::select('film_id', 'title')
            ->when($request->search, function($query, $search) {
                $query->where('title', 'like', "%$search%");
            })
            ->Paginate(100)
            ->withQueryString();

        return view('film.index', [
            'films' => $films,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($title)
    {
        $film = Film::whereTitle($title)
            ->with([
                'language:language_id,name',
                'actors:actor_id,first_name,last_name',
            ])
            ->firstOrFail();

        // dd($film->language->name);
        return view('film.show', ['film' => $film]);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Film $film)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Film $film)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Film $film)
    {
        //
    }
}
