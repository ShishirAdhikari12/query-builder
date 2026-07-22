<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actors</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>

<body class="min-h-screen bg-sky-100">

    <div class="max-w-7xl mx-auto px-6 py-10">

        <h1 class="text-4xl font-bold text-slate-800 text-center mb-10">
            All Actors
        </h1>

        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">

            @foreach ($actors as $actor)
                <div
                    class="rounded-3xl bg-white p-6 shadow-lg transition duration-300 hover:-translate-y-1 hover:shadow-2xl">

                    <div class="mb-6">
                        <p class="text-sm text-slate-400">
                            Actor #{{ $actor->actor_id }}
                        </p>

                        <h2 class="mt-1 text-xl font-semibold text-slate-800">
                            {{ $actor->first_name }} {{ $actor->last_name }}
                        </h2>
                    </div>

                    <a href="{{ route('actor.edit', $actor) }}">
                        <button
                            class="w-full rounded-xl bg-sky-600 py-3 font-semibold text-white shadow-lg shadow-sky-300/50 transition duration-200 hover:bg-sky-700 hover:-translate-y-0.5 active:translate-y-0 active:shadow-inner">
                            Edit
                        </button>
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

</body>

</html>
