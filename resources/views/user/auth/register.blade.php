<x-layouts.center>
    <div>
        <div class="mb-6 text-center">
            <h2 class="text-xl font-light tracking-tight text-white">Crie sua conta</h2>
            <p class="mt-1 text-sm text-white/40">Preencha os dados abaixo para começar.</p>
        </div>

        <form action="{{ route('user.register.store') }}" method="post" class="flex flex-col gap-4">
            @csrf

            <x-ui.input
                type="text"
                name="name"
                title="Nome"
                placeholder="Seu nome completo"
                autocomplete="name"
                required
            />

            <x-ui.input
                type="email"
                name="email"
                title="Email"
                placeholder="voce@exemplo.com"
                autocomplete="email"
                required
            />

            <x-ui.input
                type="password"
                name="password"
                title="Senha"
                placeholder="Crie uma senha"
                autocomplete="new-password"
                required
            />

            <x-ui.input
                type="password"
                name="password_confirmation"
                title="Confirme a senha"
                placeholder="Repita a senha"
                autocomplete="new-password"
                required
            />

            <x-ui.button class="mt-2">
                Cadastrar
            </x-ui.button>
        </form>

        <p class="mt-6 text-center text-sm text-white/40">
            Já possui uma conta?
            <a class="font-medium text-white underline decoration-white/30 underline-offset-4 hover:text-white/80" href="{{ route('user.login') }}">
                Acessar conta
            </a>
        </p>
    </div>
</x-layouts.center>
