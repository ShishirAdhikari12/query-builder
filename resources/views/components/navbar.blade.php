{{-- <div>
    <div class="bg-blue-200 px-4 py-2 flex gap-6">
        <a href="{{ route('home') }}" class="py-2 px-4 hover:bg-gray-300 rounded-xl">Home</a>
        <a href="{{ route('actor.index') }}" class="py-2 px-4 hover:bg-gray-300 rounded-xl">Actors</a>
        <a href="{{ route('film.index') }}" class="py-2 px-4 hover:bg-gray-300 rounded-xl">Films</a>
        <a href="{{ route('actor.create') }}"
            class="text-center py-3 px-6 rounded-xl bg-sky-600 font-semibold text-white shadow-lg shadow-sky-300/50 transition duration-200 hover:bg-sky-700 hover:-translate-y-0.5 active:translate-y-0 active:shadow-inner">
            Add Actor
        </a>
    </div>
</div> --}}

<nav class="bg-white shadow-md border-b">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex items-center justify-between h-16">

            <!-- Logo -->
            <a href="{{ route('home') }}" class="text-2xl font-bold text-sky-600 tracking-wide">
                🎬 SakilaDB
            </a>

            <!-- Navigation -->
            <div class="flex items-center gap-2">

                <a href="{{ route('home') }}"
                    class="{{ request()->routeIs('home') ? 'bg-sky-600 text-white' : 'text-slate-700 hover:bg-slate-100' }}
                    rounded-lg px-4 py-2 font-medium transition">
                    Home
                </a>

                <a href="{{ route('actor.index') }}"
                    class="{{ request()->routeIs('actor.*') ? 'bg-sky-600 text-white' : 'text-slate-700 hover:bg-slate-100' }}
                    rounded-lg px-4 py-2 font-medium transition">
                    Actors
                </a>

                <a href="{{ route('film.index') }}"
                    class="{{ request()->routeIs('film.*') ? 'bg-sky-600 text-white' : 'text-slate-700 hover:bg-slate-100' }}
                    rounded-lg px-4 py-2 font-medium transition">
                    Films
                </a>

            </div>

        </div>
    </div>
</nav>
