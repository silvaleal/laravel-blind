<x-layouts.admin>
    <div class="w-full flex flex-col gap-6">

        <header>
            <a href="{{ route('admin.users.index') }}"
                class="text-sm font-medium text-gray-500 transition hover:text-gray-700">
                &larr; Voltar para usuários
            </a>

            <div class="mt-2 flex flex-wrap items-center gap-3">
                <h1 class="text-2xl font-semibold text-gray-900">Editar usuário</h1>
                <x-ui.role-badge :role="$user->role" />
            </div>

            <p class="mt-1 text-sm text-gray-500">{{ $user->email }}</p>
        </header>

        @if ($errors->any())
            <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3">
                <p class="text-sm text-red-700">Verifique os campos destacados e tente novamente.</p>
            </div>
        @endif

        @include('admin.users._form', [
            'user' => $user,
            'action' => route('admin.users.update', $user),
            'method' => 'PUT',
            'submitLabel' => 'Salvar alterações',
        ])

    </div>
</x-layouts.admin>
