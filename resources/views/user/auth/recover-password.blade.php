<x-layouts.center>
    <div>
        <div class="mb-6 text-center">
            <h2 class="text-xl font-light tracking-tight text-white">Recupere sua senha</h2>
            <p class="mt-1 text-sm text-white/40">
                Informe seu email e enviaremos um link para redefinir sua senha.
            </p>
        </div>

        @if (session('status'))
            <div class="mb-4 rounded-lg border border-emerald-400/20 bg-emerald-400/10 p-3 text-sm text-emerald-100/90">
                {{ session('status') }}
            </div>
        @endif

        @if (session('reset_url'))
            <div class="mb-4 rounded-lg border border-sky-400/20 bg-sky-400/10 p-3 text-sm text-sky-100/90">
                <p class="mb-1 font-medium">Link de recuperação (ambiente local):</p>
                <a class="break-all underline decoration-sky-300/40 underline-offset-4 hover:text-white"
                    href="{{ session('reset_url') }}">
                    {{ session('reset_url') }}
                </a>
            </div>
        @endif

        @error('email')
            <div class="mb-4 rounded-lg border border-red-500/30 bg-red-500/10 p-3 text-sm text-red-300">
                {{ $message }}
            </div>
        @enderror

        <form action="{{ route('user.auth.recover-password.store') }}" method="post" class="flex flex-col gap-4">
            @csrf

            <x-ui.input
                type="email"
                name="email"
                title="Email"
                placeholder="voce@exemplo.com"
                autocomplete="email"
                required
            />

            <x-ui.button class="mt-2">
                Enviar link de recuperação
            </x-ui.button>
        </form>

        <p class="mt-6 text-center text-sm text-white/40">
            Lembrou a senha?
            <a class="font-medium text-white underline decoration-white/30 underline-offset-4 hover:text-white/80"
                href="{{ route('user.login') }}">
                Voltar para o login
            </a>
        </p>
    </div>
</x-layouts.center>
