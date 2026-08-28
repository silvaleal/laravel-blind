@props([
    'title',
    'routes',
])

<aside :class="open ? 'translate-x-0' : '-translate-x-full'"
    class="fixed top-0 left-0 z-30 h-screen w-64 bg-slate-900 text-white transition-transform duration-300 lg:translate-x-0">
    <div class="flex items-center justify-between px-5 py-4 border-b border-gray-700">
        <h1 class="text-xl font-bold">
            {{ $title }}
        </h1>

        <button @click="open = false" class="lg:hidden text-gray-400 hover:text-white">
            ✕
        </button>
    </div>

    <nav class="mt-5 px-3 space-y-2">

        @foreach ($routes as $route)
            <a href="{{ $route['href'] }}" class="flex items-center gap-3 rounded-lg px-4 py-3 hover:bg-gray-800 transition">
                <span>{{ $route['title'] }}</span>
            </a>
        @endforeach

    </nav>
</aside>
