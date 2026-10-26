<x-layouts.center>
    <div>
        <div class="mb-6 text-center">
            <h2 class="text-xl font-light tracking-tight text-white">Defina sua nova senha</h2>
            <p class="mt-1 text-sm text-white/40">
                Escolha uma nova senha para acessar sua conta.
            </p>
        </div>

        <div class="mb-6 rounded-lg border border-amber-400/20 bg-amber-400/10 p-4 text-sm text-amber-100/90">
            A senha será alterada para
            <span class="font-semibold text-amber-100">
                {{ $email ?? 'email desconhecido' }}
            </span>.
        </div>

        @error('email')
            <div class="mb-4 rounded-lg border border-red-500/30 bg-red-500/10 p-3 text-sm text-red-300">
                {{ $message }}
            </div>
        @enderror

        @error('token')
            <div class="mb-4 rounded-lg border border-red-500/30 bg-red-500/10 p-3 text-sm text-red-300">
                {{ $message }}
            </div>
        @enderror

        <form action="{{ route('user.password.update') }}" method="post" class="flex flex-col gap-4">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="email" value="{{ $email }}">

            <x-ui.input
                type="password"
                name="password"
                title="Nova senha"
                placeholder="Crie uma nova senha"
                autocomplete="new-password"
                required
            />

            <x-ui.input
                type="password"
                name="password_confirmation"
                title="Confirme a nova senha"
                placeholder="Repita a nova senha"
                autocomplete="new-password"
                required
            />

            <x-ui.button class="mt-2">
                Redefinir senha
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
