<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

</head>

<body class="bg-black text-white">

    <div class="flex min-h-screen flex-col items-center justify-center px-4 py-12">

        <div class="w-full max-w-md">

            <div class="mb-8 text-center">
                <a href="{{ route('home') }}" class="text-2xl font-light tracking-tight hover:text-white/80 transition">
                    {{ config('app.name') }}
                </a>
            </div>

            <div class="rounded-2xl bg-white/5 p-8 ring-1 ring-white/10">
                {{ $slot }}
            </div>

            <p class="mt-8 text-center text-xs text-white/30">&copy; {{ date('Y') }} {{ config('app.name') }}. Todos os direitos reservados.</p>

        </div>

    </div>

</body>

</html>
