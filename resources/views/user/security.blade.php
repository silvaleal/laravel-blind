<x-layouts.user>
    <div class="mx-auto flex w-full flex-col gap-6">

        @if (session('success'))
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3">
                <p class="text-sm text-emerald-700">{{ session('success') }}</p>
            </div>
        @endif

        <header>
            <h1 class="text-2xl font-semibold text-gray-900">Segurança</h1>
            <p class="mt-1 text-sm text-gray-500">Atualize seus dados de acesso e gerencie sua conta.</p>
        </header>

        <section class="rounded-2xl border border-white/10 bg-slate-900 p-6 shadow-sm">
            <div class="mb-5">
                <h2 class="text-base font-semibold text-white">Dados pessoais</h2>
                <p class="mt-1 text-sm text-white/50">Nome e email utilizados na sua conta.</p>
            </div>

            <form action="{{ route('user.security.account') }}" method="post" class="flex flex-col gap-4">
                @csrf
                @method('PUT')

                <div class="grid gap-4 sm:grid-cols-2">
                    <x-ui.input
                        type="text"
                        name="name"
                        title="Nome"
                        placeholder="Seu nome completo"
                        autocomplete="name"
                        :value="old('name', auth()->user()->name)"
                        required
                    />

                    <x-ui.input
                        type="email"
                        name="email"
                        title="Email"
                        placeholder="voce@exemplo.com"
                        autocomplete="email"
                        :value="old('email', auth()->user()->email)"
                        required
                    />
                </div>

                <div class="flex justify-end">
                    <x-ui.button class="sm:w-auto">
                        Salvar alterações
                    </x-ui.button>
                </div>
            </form>
        </section>

        <section class="rounded-2xl border border-white/10 bg-slate-900 p-6 shadow-sm">
            <div class="mb-5">
                <h2 class="text-base font-semibold text-white">Alterar senha</h2>
                <p class="mt-1 text-sm text-white/50">Use uma senha forte e diferente das anteriores.</p>
            </div>

            <form action="{{ url('/user/security/password') }}" method="post" class="flex flex-col gap-4">
                @csrf
                @method('PUT')

                <x-ui.input
                    type="password"
                    name="current_password"
                    title="Senha atual"
                    placeholder="••••••••"
                    autocomplete="current-password"
                    required
                />

                <div class="grid gap-4 sm:grid-cols-2">
                    <x-ui.input
                        type="password"
                        name="password"
                        title="Nova senha"
                        placeholder="Crie uma senha"
                        autocomplete="new-password"
                        required
                    />

                    <x-ui.input
                        type="password"
                        name="password_confirmation"
                        title="Confirme a nova senha"
                        placeholder="Repita a senha"
                        autocomplete="new-password"
                        required
                    />
                </div>

                <div class="flex justify-end">
                    <x-ui.button class="sm:w-auto">
                        Atualizar senha
                    </x-ui.button>
                </div>
            </form>
        </section>

        <section class="rounded-2xl border border-red-900/70 bg-red-950/50 p-6">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-base font-semibold text-red-400">Excluir conta</h2>
                    <p class="mt-1 text-sm text-red-200/60">
                        Todos os seus dados serão removidos permanentemente. Esta ação não pode ser desfeita.
                    </p>
                </div>

                <div class="shrink-0">
                    <x-ui.modal title="Confirmar exclusão">
                        <x-slot name="button">
                            <span class="inline-flex w-full items-center justify-center rounded-lg bg-red-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-red-500 active:scale-[.98]">
                                Excluir conta
                            </span>
                        </x-slot>

                        <div class="flex flex-col gap-4">
                            <p class="text-sm text-gray-600">
                                Confirme com sua senha para excluir a conta. Todos os dados serão apagados e não poderão ser recuperados.
                            </p>

                            <form action="{{ url('/user/security') }}" method="post" class="flex flex-col gap-4">
                                @csrf
                                @method('DELETE')

                                <div class="flex flex-col gap-1.5">
                                    <label for="confirm_password" class="text-sm font-medium text-gray-700">
                                        Senha
                                    </label>
                                    <input
                                        id="confirm_password"
                                        name="password"
                                        type="password"
                                        placeholder="••••••••"
                                        autocomplete="current-password"
                                        required
                                        class="w-full rounded-lg border border-gray-300 bg-white px-3.5 py-2.5 text-sm text-gray-900 placeholder-gray-400 shadow-sm outline-none transition focus:border-red-500 focus:ring-2 focus:ring-red-500/30"
                                    >
                                    @error('password')
                                        <p class="text-xs text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>

                                <x-ui.button variant="danger">
                                    Excluir minha conta
                                </x-ui.button>
                            </form>
                        </div>
                    </x-ui.modal>
                </div>
            </div>
        </section>

    </div>
</x-layouts.user>
