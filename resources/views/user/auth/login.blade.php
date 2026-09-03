<x-layouts.center>
    <div>
        <div class="mb-6 text-center">
            <h2 class="text-xl font-light tracking-tight text-white">Acesse sua conta</h2>
            <p class="mt-1 text-sm text-white/40">Entre com suas credenciais para continuar.</p>
        </div>

        <form action="{{ route('user.login.store') }}" method="post" class="flex flex-col gap-4">
            @csrf

            <x-ui.input
                type="email"
                name="email"
                title="Email"
                placeholder="voce@exemplo.com"
                required
            />

            <x-ui.input
                type="password"
                name="password"
                title="Senha"
                placeholder="••••••••"
                required
            />

            <x-ui.button class="mt-2">
                Entrar
            </x-ui.button>
        </form>

        <p class="mt-6 text-center text-sm text-white/40">
            Ainda não tem conta?
            <a class="font-medium text-white underline decoration-white/30 underline-offset-4 hover:text-white/80" href="{{ route('user.register') }}">
                Criar conta
            </a>
        </p>
    </div>
</x-layouts.center>
