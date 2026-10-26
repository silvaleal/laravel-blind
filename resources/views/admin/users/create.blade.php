<x-layouts.admin>
    <div class="w-full flex flex-col gap-6">

        <header>
            <a href="{{ route('admin.users.index') }}"
                class="text-sm font-medium text-gray-500 transition hover:text-gray-700">
                &larr; Voltar para usuários
            </a>

            <h1 class="mt-2 text-2xl font-semibold text-gray-900">Novo usuário</h1>
            <p class="mt-1 text-sm text-gray-500">Cadastre uma nova conta e defina o nível de acesso.</p>
        </header>

        @if ($errors->any())
            <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3">
                <p class="text-sm text-red-700">Verifique os campos destacados e tente novamente.</p>
            </div>
        @endif

        @include('admin.users._form', [
            'action' => route('admin.users.store'),
            'method' => 'POST',
            'submitLabel' => 'Criar usuário',
        ])

    </div>
</x-layouts.admin>
