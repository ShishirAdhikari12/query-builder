<?php

namespace App\Http\Controllers;

use App\Models\Actor;
use Illuminate\Http\Request;

class ActorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = trim($request->search);
        $parts = preg_split('/\s+/', $search);

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
        // $actors = Actor::cursorPaginate(100);

        return view('actor.index', [
            'actors' => $actors,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('actor.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
        ]);

        Actor::create([
            'first_name' => strtoupper($validated['first_name']),
            'last_name' => strtoupper($validated['last_name']),
        ]);

        return redirect()->route('actor.index')->with('success', 'Actor Created Successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($first_name, $last_name)
    {
        // $actor = Actor::where('first_name', $first_name)->where('last_name', $last_name)->firstOrFail();

        // $films = $actor->films()->select('film.film_id', 'film.title')->get();
        $actor = Actor::whereFirstName($first_name)
            ->whereLastName($last_name)
            ->with('films:film_id,title')
            ->firstOrFail();

        // dd($actor);
        return view('actor.show', [
            'actor' => $actor,

        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Actor $actor)
    {
        return view('actor.edit', [
            'actor' => $actor,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Actor $actor)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
        ]);

        $actor->update([
            'first_name' => strtoupper($validated['first_name']),
            'last_name' => strtoupper($validated['last_name']),
        ]);

        // return redirect()->route('actor.index')->with('success', 'Actor updated successfully.');
        return redirect()->route('actor.index', [
            'cursor' => $request->cursor,
        ])->with('success', 'Actor updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Actor $actor)
    {
        $actor->delete();

        return redirect()->back();
    }

    public function topActors()
    {
        $actors = Actor::withCount('films')
            ->orderByDesc('films_count')
            ->paginate(100);

        // $actors = Actor::cursorPaginate(100);
        // dd($actors);
        return view('actor.index', [
            'actors' => $actors,
        ]);
    }
}
