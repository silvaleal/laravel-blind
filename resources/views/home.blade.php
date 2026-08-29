<x-layouts.app>

    <div>
        <h2>{{ config('app.name') }}</h2>
    </div>

    <div>{{ Auth::user()->name ?? "Usuário" }}</div>

</x-layouts.app>
