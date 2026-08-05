<x-layouts.app>
    <x-slot:title>
        Actors
    </x-slot:title>

    <div class="min-h-screen bg-sky-100">

        <div class="max-w-7xl mx-auto px-6 py-10 relative">

            <a href="{{ route('actor.top') }}" class="w-1/3 absolute left-0 top-12">
                <span class="rounded-lg bg-sky-600 px-5 py-2 text-white hover:bg-sky-700">Top Actors</span>
            </a>
            <div class="flex justify-center">
                <a href="{{ route('actor.index') }}" class="text-4xl font-bold text-slate-800 text-center mb-10">
                    All Actors
                </a>
            </div>

            <div class="w-1/3 absolute right-0 top-12">
                <form action="{{ route('actor.index') }}" method="GET" class="mb-6">
                    <div class="flex gap-3">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Search actors..."
                            class="w-full bg-white rounded-lg border border-slate-300 px-4 py-2 focus:border-sky-500 focus:ring-sky-500">

                        <button type="submit" class="rounded-lg bg-sky-600 px-5 py-2 text-white hover:bg-sky-700">
                            Search
                        </button>
                    </div>
                </form>

            </div>

            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">

                @foreach ($actors as $actor)
                    <div
                        class="w-full rounded-3xl bg-white p-6 shadow-lg transition duration-300 hover:-translate-y-1 hover:shadow-2xl">

                        <div class="mb-6">
                            <p class="text-sm text-slate-400">
                                Actor #{{ $actor->actor_id }}
                            </p>

                            <h2 class="mt-1 text-xl font-semibold text-slate-800">
                                {{ $actor->first_name }} {{ $actor->last_name }}
                            </h2>
                        </div>

                        <div class="flex justify-between w-full gap-1">
                            {{-- <a href="{{ route('actor.edit', ['actor' => $actor, 'cursor' => request('cursor')]) }}"
                                class="w-full text-center py-3 rounded-xl bg-amber-600 font-semibold text-white shadow-lg shadow-sky-300/50 transition duration-200 hover:bg-amber-700 hover:-translate-y-0.5 active:translate-y-0 active:shadow-inner">

                                Edit

                            </a> --}}

                            {{-- <a href="{{ route('actor.delete', $actor) }}"
                                class="w-full text-center py-3 rounded-xl bg-red-600 font-semibold text-white shadow-lg shadow-sky-300/50 transition duration-200 hover:bg-red-700 hover:-translate-y-0.5 active:translate-y-0 active:shadow-inner">

                                Delete

                            </a> --}}
                        </div>
                        <br>
                        <a
                            href="{{ route('actor.show', ['first_name' => $actor->first_name, 'last_name' => $actor->last_name]) }}">
                            <div
                                class="w-full text-center mt-3 py-3 px-6 rounded-xl bg-blue-600 font-semibold text-white shadow-lg shadow-blue-300/50 transition duration-200 hover:bg-blue-700 hover:-translate-y-0.5 active:translate-y-0 active:shadow-inner">
                                Show
                            </div>
                        </a>

                    </div>
                @endforeach
            </div>

        </div>

        @if (session('success'))
            <div id="toast"
                class="fixed top-6 right-6 rounded-xl bg-green-600 px-6 py-4 text-white shadow-2xl transition-all duration-500">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div id="toast"
                class="fixed top-6 right-6 rounded-xl bg-red-600 px-6 py-4 text-white shadow-2xl transition-all duration-500">
                {{ session('error') }}
            </div>
        @endif

        <script>
            const toast = document.getElementById('toast');
            if (toast) {
                setTimeout(() => {
                    toast.classList.add(
                        'opacity-0',
                        'translate-x-10'
                    );
                    setTimeout(() => toast.remove(), 500);
                }, 2000);
            }
        </script>

    </div>

    <div class="flex justify-center m-10 bg-sky-100 py-10">
        <div class="w-3/4 ">

            {{ $actors->links() }}
        </div>
    </div>

</x-layouts.app>
