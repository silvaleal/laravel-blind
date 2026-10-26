<x-layouts.admin>
    <div class="w-full flex flex-col gap-6">

        @if (session('success'))
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3">
                <p class="text-sm text-emerald-700">{{ session('success') }}</p>
            </div>
        @endif

        @if (session('error'))
            <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3">
                <p class="text-sm text-red-700">{{ session('error') }}</p>
            </div>
        @endif

        <header class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">Usuários</h1>
                <p class="mt-1 text-sm text-gray-500">Gerencie as contas cadastradas na plataforma.</p>
            </div>

            <a href="{{ route('admin.users.create') }}"
                class="inline-flex items-center justify-center rounded-lg bg-gray-900 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-gray-800">
                Novo usuário
            </a>
        </header>

        <form method="get" action="{{ route('admin.users.index') }}"
            class="grid gap-3 rounded-2xl border border-gray-200 bg-white p-4 shadow-sm sm:grid-cols-2 lg:grid-cols-4">
            <div class="flex flex-col gap-1.5">
                <label for="search" class="text-sm font-medium text-gray-700">Buscar</label>
                <input id="search" name="search" type="search" value="{{ $filters['search'] ?? '' }}"
                    placeholder="Nome ou email"
                    class="w-full rounded-lg border border-gray-300 bg-white px-3.5 py-2.5 text-sm text-gray-900 placeholder-gray-400 shadow-sm outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/30">
            </div>

            <div class="flex flex-col gap-1.5">
                <label for="role" class="text-sm font-medium text-gray-700">Tipo</label>
                <select id="role" name="role"
                    class="w-full rounded-lg border border-gray-300 bg-white px-3.5 py-2.5 text-sm text-gray-900 shadow-sm outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/30">
                    <option value="">Todos</option>
                    <option value="user" @selected(($filters['role'] ?? '') === 'user')>Usuário</option>
                    <option value="admin" @selected(($filters['role'] ?? '') === 'admin')>Administrador</option>
                </select>
            </div>

            <div class="flex flex-col gap-1.5">
                <label for="status" class="text-sm font-medium text-gray-700">Situação</label>
                <select id="status" name="status"
                    class="w-full rounded-lg border border-gray-300 bg-white px-3.5 py-2.5 text-sm text-gray-900 shadow-sm outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/30">
                    <option value="active" @selected(($filters['status'] ?? 'active') === 'active')>Ativos</option>
                    <option value="trashed" @selected(($filters['status'] ?? '') === 'trashed')>Excluídos</option>
                    <option value="all" @selected(($filters['status'] ?? '') === 'all')>Todos</option>
                </select>
            </div>

            <div class="flex items-end gap-2">
                <button type="submit"
                    class="inline-flex flex-1 items-center justify-center rounded-lg bg-gray-900 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-gray-800">
                    Filtrar
                </button>

                @if (array_filter($filters))
                    <a href="{{ route('admin.users.index') }}"
                        class="inline-flex items-center justify-center rounded-lg border border-gray-300 px-4 py-2.5 text-sm font-medium text-gray-600 transition hover:bg-gray-50">
                        Limpar
                    </a>
                @endif
            </div>
        </form>

        <section class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100 text-sm">
                    <thead class="bg-gray-50 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                        <tr>
                            <th class="px-5 py-3">Usuário</th>
                            <th class="px-5 py-3">Tipo</th>
                            <th class="px-5 py-3">Cadastro</th>
                            <th class="px-5 py-3 text-right">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($users as $user)
                            <tr class="transition hover:bg-gray-50">
                                <td class="px-5 py-4">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <p class="font-medium text-gray-900">{{ $user->name }}</p>

                                        @if ($user->trashed())
                                            <span class="inline-flex items-center rounded-full bg-red-50 px-2.5 py-0.5 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-200">
                                                Excluído
                                            </span>
                                        @endif
                                    </div>
                                    <p class="text-xs text-gray-500">{{ $user->email }}</p>
                                </td>
                                <td class="px-5 py-4">
                                    <x-ui.role-badge :role="$user->role" />
                                </td>
                                <td class="px-5 py-4 text-gray-500">
                                    {{ $user->created_at->format('d/m/Y') }}
                                </td>
                                <td class="px-5 py-4">
                                    <div class="flex flex-wrap items-center justify-end gap-2">
                                        @if ($user->trashed())
                                            <form action="{{ route('admin.users.restore', $user) }}" method="post">
                                                @csrf
                                                @method('PATCH')

                                                <button type="submit"
                                                    class="rounded-lg bg-emerald-600 px-3 py-1.5 text-xs font-semibold text-white transition hover:bg-emerald-500">
                                                    Restaurar
                                                </button>
                                            </form>

                                            <form action="{{ route('admin.users.force-delete', $user) }}" method="post"
                                                onsubmit="return confirm('Excluir permanentemente este usuário? Esta ação não pode ser desfeita.')">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                    class="rounded-lg border border-red-200 bg-red-50 px-3 py-1.5 text-xs font-semibold text-red-700 transition hover:bg-red-100">
                                                    Excluir permanentemente
                                                </button>
                                            </form>
                                        @else
                                            <a href="{{ route('admin.users.edit', $user) }}"
                                                class="rounded-lg border border-gray-300 px-3 py-1.5 text-xs font-semibold text-gray-700 transition hover:bg-gray-100">
                                                Editar
                                            </a>

                                            <form action="{{ route('admin.users.destroy', $user) }}" method="post"
                                                onsubmit="return confirm('Excluir este usuário? Ele poderá ser restaurado depois.')">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                    class="rounded-lg border border-red-200 bg-red-50 px-3 py-1.5 text-xs font-semibold text-red-700 transition hover:bg-red-100">
                                                    Excluir
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-5 py-10 text-center text-sm text-gray-500">
                                    Nenhum usuário encontrado.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($users->hasPages())
                <div class="border-t border-gray-100 px-5 py-4">
                    {{ $users->links() }}
                </div>
            @endif
        </section>

    </div>
</x-layouts.admin>
