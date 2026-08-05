<x-layouts.app>
    <x-slot:title>
        {{ $film->title }}
    </x-slot:title>

    <div class="min-h-screen bg-slate-100 py-10">
        <div class="max-w-5xl mx-auto px-6">

            <div class="overflow-hidden rounded-2xl bg-white shadow-lg">

                <!-- Header -->
                <div class="bg-sky-600 px-8 py-8 text-white">
                    <div class="flex items-start justify-between gap-6">
                        <div>
                            <p class="text-sky-100 text-sm uppercase tracking-widest">
                                Film #{{ $film->film_id }}
                            </p>

                            <h1 class="mt-2 text-4xl font-bold">
                                {{ $film->title }}
                            </h1>

                            <div class="mt-5 flex flex-wrap gap-3">
                                <span class="rounded-full bg-white/20 px-4 py-1 text-sm">
                                    {{ $film->rating }}
                                </span>

                                <span class="rounded-full bg-white/20 px-4 py-1 text-sm">
                                    {{ $film->release_year }}
                                </span>

                                <span class="rounded-full bg-white/20 px-4 py-1 text-sm">
                                    {{ $film->length }} min
                                </span>

                                <span class="rounded-full bg-white/20 px-4 py-1 text-sm">
                                    {{ $film->language->name }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Content -->
                <div class="p-8 space-y-10">

                    <!-- Description -->
                    <section>
                        <h2 class="mb-3 text-xl font-semibold text-slate-800">
                            Description
                        </h2>

                        <p class="leading-8 text-slate-600">
                            {{ $film->description }}
                        </p>
                    </section>

                    <!-- Details -->
                    <section>
                        <h2 class="mb-5 text-xl font-semibold text-slate-800">
                            Film Information
                        </h2>

                        <div class="grid gap-4 md:grid-cols-2">

                            <div class="rounded-xl border p-4">
                                <p class="text-sm text-slate-500">Film ID</p>
                                <p class="mt-1 text-lg font-semibold">{{ $film->film_id }}</p>
                            </div>

                            <div class="rounded-xl border p-4">
                                <p class="text-sm text-slate-500">Language</p>
                                <p class="mt-1 text-lg font-semibold">{{ $film->language->name }}</p>
                            </div>

                            <div class="rounded-xl border p-4">
                                <p class="text-sm text-slate-500">Release Year</p>
                                <p class="mt-1 text-lg font-semibold">{{ $film->release_year }}</p>
                            </div>

                            <div class="rounded-xl border p-4">
                                <p class="text-sm text-slate-500">Rating</p>
                                <p class="mt-1 text-lg font-semibold">{{ $film->rating }}</p>
                            </div>

                            <div class="rounded-xl border p-4">
                                <p class="text-sm text-slate-500">Length</p>
                                <p class="mt-1 text-lg font-semibold">{{ $film->length }} minutes</p>
                            </div>

                            <div class="rounded-xl border p-4">
                                <p class="text-sm text-slate-500">Rental Duration</p>
                                <p class="mt-1 text-lg font-semibold">{{ $film->rental_duration }} days</p>
                            </div>

                            <div class="rounded-xl border p-4">
                                <p class="text-sm text-slate-500">Rental Rate</p>
                                <p class="mt-1 text-lg font-semibold">${{ $film->rental_rate }}</p>
                            </div>

                            <div class="rounded-xl border p-4">
                                <p class="text-sm text-slate-500">Replacement Cost</p>
                                <p class="mt-1 text-lg font-semibold">${{ $film->replacement_cost }}</p>
                            </div>

                        </div>
                    </section>

                    <!-- Special Features -->
                    <section>
                        <h2 class="mb-4 text-xl font-semibold text-slate-800">
                            Special Features
                        </h2>

                        <div class="flex flex-wrap gap-3">
                            @foreach (explode(',', $film->special_features) as $feature)
                                <span class="rounded-full bg-sky-100 px-4 py-2 text-sm font-medium text-sky-700">
                                    {{ trim($feature) }}
                                </span>
                            @endforeach
                        </div>
                    </section>

                    <!-- Category -->
                    <section>
                        <h2 class="mb-4 text-xl font-semibold text-slate-800">
                            Category
                        </h2>

                        <div class="flex flex-wrap gap-3">
                            @foreach ($film->categories as $category)
                                <a href="{{ route('film.category', ['name' => $category->name]) }}">

                                    <span class="rounded-full bg-sky-100 px-4 py-2 text-sm font-medium text-sky-700">
                                        {{ $category->name }}
                                    </span>
                                </a>
                            @endforeach
                        </div>
                    </section>


                    <!-- Cast -->
                    <section>
                        <h2 class="mb-4 text-xl font-semibold text-slate-800">
                            Cast
                        </h2>

                        @if ($film->actors->isNotEmpty())
                            <div class="flex flex-wrap gap-3">
                                @foreach ($film->actors as $actor)
                                    <a href="{{ route('actor.show', ['first_name'=>$actor->first_name, 'last_name'=>$actor->last_name]) }}" class="py-2">
                                        <span
                                            class="rounded-full bg-slate-100 px-4 py-2 text-sm font-medium text-slate-700 border">
                                            {{ $actor->first_name }} {{ $actor->last_name }}
                                        </span>
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <p class="text-slate-500 italic">
                                No actors available.
                            </p>
                        @endif
                    </section>

                    <!-- Footer -->
                    <div class="flex items-center justify-between border-t pt-6">

                        <a href="{{ url()->previous() }}"
                            class="rounded-lg bg-slate-700 px-5 py-2.5 font-medium text-white transition hover:bg-slate-800">
                            ← Back to Films
                        </a>

                    </div>

                </div>

            </div>

        </div>
    </div>
</x-layouts.app>
