<x-layouts.app>
    <x-slot:title>
        Edit Actor:{{ $actor->first_name }}
    </x-slot:title>

<div class="min-h-screen bg-sky-100 flex items-center justify-center p-8">

    <form action="{{ route('actor.update', $actor) }}" method="POST" class="w-full max-w-md bg-white rounded-3xl shadow-xl p-8">
        @csrf
        @method('PUT')

        <h1 class="text-3xl font-bold text-slate-800 text-center mb-8">
            Edit Actor
        </h1>

        <div class="space-y-5">

            <div>
                <label class="block text-sm font-medium text-slate-600 mb-2">
                    First Name
                </label>
                <input type="text" name="first_name" value="{{ old('first_name', $actor->first_name) }}"
                    class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-slate-700 placeholder:text-slate-400 outline-none transition duration-200 focus:border-sky-500 focus:bg-white focus:ring-4 focus:ring-sky-200">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-600 mb-2">
                    Last Name
                </label>
                <input type="text" name="last_name" value="{{ old('last_name', $actor->last_name) }}"
                    class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-slate-700 placeholder:text-slate-400 outline-none transition duration-200 focus:border-sky-500 focus:bg-white focus:ring-4 focus:ring-sky-200">
            </div>
            <input type="hidden" name="cursor" value="{{ request('cursor') }}">

            <button type="submit"
                class="w-full rounded-xl bg-sky-600 py-3 text-white font-semibold shadow-lg shadow-sky-300/50 transition duration-200 hover:bg-sky-700 hover:-translate-y-0.5 active:translate-y-0 active:shadow-inner">
                Update Actor
            </button>

        </div>

    </form>

</div>

</x-layouts.app>
