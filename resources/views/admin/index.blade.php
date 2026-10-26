<x-layouts.admin>
    <div class="w-full flex flex-col gap-6">

        <header class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">Painel administrativo</h1>
                <p class="mt-1 text-sm text-gray-500">Visão geral dos usuários e da plataforma.</p>
            </div>

            <a href="{{ route('admin.users.index') }}"
                class="inline-flex items-center justify-center rounded-lg bg-gray-900 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-gray-800">
                Gerenciar usuários
            </a>
        </header>

        <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-gray-500">Total de usuários</p>
                <p class="mt-2 text-3xl font-semibold text-gray-900">{{ $stats['total'] }}</p>
                <p class="mt-1 text-xs text-gray-400">{{ $stats['trashed'] }} excluído(s)</p>
            </div>

            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-gray-500">Administradores</p>
                <p class="mt-2 text-3xl font-semibold text-indigo-600">{{ $stats['admins'] }}</p>
                <p class="mt-1 text-xs text-gray-400">Com acesso ao painel</p>
            </div>

            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-gray-500">Usuários comuns</p>
                <p class="mt-2 text-3xl font-semibold text-gray-900">{{ $stats['users'] }}</p>
                <p class="mt-1 text-xs text-gray-400">Contas ativas</p>
            </div>

            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-gray-500">Novos este mês</p>
                <p class="mt-2 text-3xl font-semibold text-emerald-600">{{ $stats['new_this_month'] }}</p>
                <p class="mt-1 text-xs text-gray-400">Cadastros desde {{ now()->startOfMonth()->format('d/m') }}</p>
            </div>
        </section>

        <section class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
            <div class="flex items-center justify-between border-b border-gray-100 px-5 py-4">
                <div>
                    <h2 class="text-base font-semibold text-gray-900">Usuários recentes</h2>
                    <p class="mt-0.5 text-sm text-gray-500">Últimos cadastros realizados.</p>
                </div>

                <a href="{{ route('admin.users.index') }}"
                    class="text-sm font-medium text-indigo-600 transition hover:text-indigo-500">
                    Ver todos
                </a>
            </div>

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
                        @forelse ($recentUsers as $user)
                            <tr class="transition hover:bg-gray-50">
                                <td class="px-5 py-4">
                                    <p class="font-medium text-gray-900">{{ $user->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $user->email }}</p>
                                </td>
                                <td class="px-5 py-4">
                                    <x-ui.role-badge :role="$user->role" />
                                </td>
                                <td class="px-5 py-4 text-gray-500">
                                    {{ $user->created_at->format('d/m/Y') }}
                                </td>
                                <td class="px-5 py-4 text-right">
                                    <a href="{{ route('admin.users.edit', $user) }}"
                                        class="text-sm font-medium text-indigo-600 transition hover:text-indigo-500">
                                        Editar
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-5 py-10 text-center text-sm text-gray-500">
                                    Nenhum usuário cadastrado ainda.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

    </div>
</x-layouts.admin>
