@props([
    'title' => null,
])

<div x-data="{ open: false }">

    @if (isset($button))
        <div @click="open = true" class="cursor-pointer">
            {{ $button }}
        </div>
    @else
        <button
            @click="open = true"
            class="rounded-lg bg-blue-600 px-5 py-2 text-white hover:bg-blue-700 transition">
            Abrir Modal
        </button>
    @endif

    <div
        x-show="open"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4"
    >

        <div
            @click.outside="open = false"
            class="w-full max-w-md rounded-xl bg-white shadow-xl"
        >

            {{-- Header --}}
            @if($title)
                <div class="flex items-center justify-between border-b px-6 py-4">
                    <h2 class="text-lg font-semibold text-gray-800">
                        {{ $title }}
                    </h2>

                    <button
                        @click="open = false"
                        class="text-gray-400 hover:text-gray-600 text-xl"
                    >
                        &times;
                    </button>
                </div>
            @endif


            {{-- Content --}}
            <div class="p-6">
                {{ $slot }}
            </div>


            {{-- Footer --}}
            <div class="flex justify-end gap-3 border-t px-6 py-4">

                <button
                    @click="open = false"
                    class="rounded-lg px-4 py-2 text-gray-600 hover:bg-gray-100 transition"
                >
                    Fechar
                </button>

            </div>

        </div>

    </div>

</div>