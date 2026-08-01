<x-layouts.app>
    <x-slot:title>
        Actor Details
    </x-slot:title>

    <div class="max-w-3xl mx-auto mt-10 bg-white shadow-lg rounded-xl p-8">

        <h1 class="text-4xl font-bold text-gray-800 border-b pb-4">
            🎬 Actor Details
        </h1>

        <div class="mt-6">
            <p class="text-gray-500 text-sm uppercase tracking-wide">
                Full Name
            </p>
            <p class="text-2xl font-semibold text-gray-900">
                {{ $actor->first_name }} {{ $actor->last_name }}
            </p>
        </div>

        <div class="mt-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">
                Movies
            </h2>

            <ul class="space-y-3">
                @foreach ($actor->films as $film)
                    <li
                        class="flex items-center justify-between bg-gray-100 hover:bg-blue-50 transition rounded-lg px-4 py-3">
                        <span class="font-medium text-gray-800">
                            {{ $film->title }}
                        </span>

                        <span class="text-sm bg-blue-100 text-blue-700 px-3 py-1 rounded-full">
                            Film
                        </span>
                    </li>
                @endforeach
            </ul>

            @if ($actor->films->isEmpty())
                <p class="text-gray-500 italic mt-4">
                    No films found for this actor.
                </p>
            @endif
        </div>

    </div>
</x-layouts.app>
