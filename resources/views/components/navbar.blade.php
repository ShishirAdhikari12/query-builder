<div>
    <div class="bg-blue-200 px-4 py-2 flex gap-6">
        <a href="{{ route('home') }}" class="py-2 px-4 hover:bg-gray-300 rounded-xl">Home</a>
        <a href="{{ route('actor.index') }}" class="py-2 px-4 hover:bg-gray-300 rounded-xl">Actors</a>
        <a href="{{ route('actor.create') }}"
            class="text-center py-3 px-6 rounded-xl bg-sky-600 font-semibold text-white shadow-lg shadow-sky-300/50 transition duration-200 hover:bg-sky-700 hover:-translate-y-0.5 active:translate-y-0 active:shadow-inner">
            Add Actor
        </a>
    </div>
</div>
