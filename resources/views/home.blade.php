<x-layouts.app>

    <div class="min-h-screen bg-black text-white flex flex-col items-center justify-center px-6 text-center">

        <div class="flex flex-col items-center">
            <p class="text-xs uppercase tracking-[0.3em] text-white/40 mb-6">
                laravel-blind
            </p>

            <h1 class="text-5xl font-light tracking-tight">
                "Hello World"
            </h1>

            <p class="mt-6 max-w-md text-white/50 text-sm leading-relaxed">
                Um STARTER KIT para o Laravel.
            </p>

            <div class="mt-8 flex items-center gap-4 text-sm">
                <p class="text-white/40">
                    Olá, {{ Auth::user()->name ?? 'visitante' }}.
                </p>
                <span class="text-white/20">·</span>
                <a href="{{ Auth::check() ? route('user.index') : route('user.login') }}"
                   class="text-white/70 hover:text-white underline underline-offset-4 transition">
                    {{ Auth::check() ? 'Ir para minha área' : 'Entrar' }}
                </a>
            </div>
        </div>

    </div>

</x-layouts.app>
