<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? config('app.name', 'Laravel') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body>
    <nav>
        <x-navbar/>
    </nav>
    <main class="p-6">
        {{ $slot }}
    </main>
    <footer>

    </footer>
</body>
</html>