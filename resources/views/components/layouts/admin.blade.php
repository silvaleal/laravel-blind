<x-layouts.app>
    <div x-data="{ open: false }" class="min-h-screen bg-gray-100">

        <div x-show="open" @click="open = false" class="fixed inset-0 z-20 bg-black/50 lg:hidden" x-transition>
        </div>

        <x-partials.sidebar title="Admin" :routes="[['title' => 'Início', 'href' => route('admin.index')]]"/>

        <main class="lg:ml-64">

            <header class="bg-white shadow px-5 py-4 lg:hidden">
                <button @click="open = true" class="text-gray-700 text-2xl">
                    ☰
                </button>
            </header>

            <section class="p-6">
                {{$slot}}
            </section>

        </main>

    </div>


    <script src="//unpkg.com/alpinejs" defer></script>
</x-layouts.app>
