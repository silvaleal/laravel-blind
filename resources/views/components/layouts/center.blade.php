<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

</head>

<body class="bg-gray-50">

    <div class="flex min-h-screen flex-col items-center justify-center px-4 py-12">

        <div class="w-full max-w-md">

            <div class="mb-8 text-center">
                <h1 class="text-xl font-semibold tracking-tight text-gray-900">{{ config('app.name') }}</h1>
            </div>

            {{-- @if ($errors->any())
                <div class="mb-4 flex items-start gap-3 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                    <ul class="flex flex-col gap-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif --}}

            <div class="rounded-2xl bg-white p-8 shadow-sm ring-1 ring-gray-200">
                {{ $slot }}
            </div>

            <p class="mt-8 text-center text-xs text-gray-400">&copy; {{ date('Y') }} {{ config('app.name') }}. Todos os direitos reservados.</p>

        </div>

    </div>

</body>

</html>
