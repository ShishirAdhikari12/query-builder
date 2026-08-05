{{-- <x-layouts.app>
    <x-slot:title>
        Films
    </x-slot:title>

    <div class="min-h-screen bg-sky-100">

        <div class="max-w-7xl mx-auto px-6 py-10">

            <div class="mt-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">
                    Movies
                </h2>

                <ul class="space-y-3">
                    @foreach ($films as $film)
                        <li
                            class="flex items-center justify-between bg-gray-100 hover:bg-blue-50 transition rounded-lg px-4 py-3">
                            <span class="font-medium text-gray-800">
                                {{ $film->film_id }} {{ $film->title }}
                            </span>

                            <span>
                                <a href="{{ route('film.show', ['title' => $film->title]) }}"
                                    class="text-sm bg-blue-100 text-blue-700 px-3 py-1 rounded-full">
                                    Show
                                </a>
                            </span>
                        </li>
                    @endforeach
                </ul>

                @if ($films->isEmpty())
                    <p class="text-gray-500 italic mt-4">
                        No films found.
                    </p>
                @endif
            </div>

        </div>

        

    </div>

    <div class="flex justify-center m-10 bg-sky-100 py-10">
        <div class="w-3/4 ">

            {{ $films->links() }}
        </div>
    </div>

</x-layouts.app> --}}


<x-layouts.app>
    <x-slot:title>
        Films
    </x-slot:title>

    <div class="min-h-screen bg-slate-100 py-10">
        <div class="max-w-6xl mx-auto px-6">

            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">

                <!-- Header -->
                <div class="flex items-center justify-between px-8 py-6 border-b">
                    <div>
                        <a href="{{ route('film.index') }}">
                            <h1 class="text-3xl font-bold text-slate-800">
                                🎬 Films
                            </h1>
                        </a>
                        <p class="text-sm text-slate-500 mt-1">
                            Showing {{ $films->firstItem() }}–{{ $films->lastItem() }}
                            of {{ $films->total() }} films
                        </p>
                    </div>
                    <div>
                        <form action="{{ route('film.index') }}" method="GET" class="mb-6">
                            <div class="flex gap-3">
                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="Search films..."
                                    class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:border-sky-500 focus:ring-sky-500">

                                <button type="submit"
                                    class="rounded-lg bg-sky-600 px-5 py-2 text-white hover:bg-sky-700">
                                    Search
                                </button>
                            </div>
                        </form>

                    </div>
                </div>

                <!-- Table Header -->
                <div class="grid grid-cols-12 px-8 py-3 bg-slate-50 text-sm font-semibold text-slate-600 border-b">
                    <div class="col-span-1">ID</div>
                    <div class="col-span-9">Title</div>
                    <div class="col-span-2 text-right">Action</div>
                </div>

                <!-- Films -->
                @forelse ($films as $film)
                    <div class="grid grid-cols-12 items-center px-8 py-4 border-b hover:bg-sky-50 transition">

                        <div class="col-span-1 font-semibold text-slate-600">
                            {{ $film->film_id }}
                        </div>

                        <div class="col-span-9 text-slate-800">
                            {{ $film->title }}
                        </div>

                        <div class="col-span-2 text-right">
                            <a href="{{ route('film.show', ['title' => $film->title]) }}"
                                class="inline-flex items-center rounded-lg bg-sky-600 px-4 py-2 text-sm font-medium text-white hover:bg-sky-700 transition">
                                Show
                            </a>
                        </div>

                    </div>
                @empty
                    <div class="py-16 text-center text-slate-500">
                        No films found.
                    </div>
                @endforelse

                <!-- Pagination -->
                <div class="px-8 py-6 bg-slate-50 border-t">
                    {{ $films->links() }}
                </div>

            </div>

        </div>
    </div>
</x-layouts.app>
