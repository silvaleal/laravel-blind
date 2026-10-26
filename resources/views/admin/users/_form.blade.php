@php
    $user = $user ?? null;
    $method = $method ?? 'POST';
@endphp

<form action="{{ $action }}" method="post"
    class="flex flex-col gap-5 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
    @csrf

    @if ($method !== 'POST')
        @method($method)
    @endif

    <div class="grid gap-4 sm:grid-cols-2">
        <div class="flex flex-col gap-1.5">
            <label for="name" class="text-sm font-medium text-gray-700">Nome</label>
            <input id="name" name="name" type="text" value="{{ old('name', $user?->name) }}"
                placeholder="Nome completo" autocomplete="name" required
                class="w-full rounded-lg border bg-white px-3.5 py-2.5 text-sm text-gray-900 placeholder-gray-400 shadow-sm outline-none transition focus:ring-2 @error('name') border-red-500 focus:border-red-500 focus:ring-red-500/30 @else border-gray-300 focus:border-indigo-500 focus:ring-indigo-500/30 @enderror">

            @error('name')
                <p class="text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex flex-col gap-1.5">
            <label for="email" class="text-sm font-medium text-gray-700">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email', $user?->email) }}"
                placeholder="voce@exemplo.com" autocomplete="email" required
                class="w-full rounded-lg border bg-white px-3.5 py-2.5 text-sm text-gray-900 placeholder-gray-400 shadow-sm outline-none transition focus:ring-2 @error('email') border-red-500 focus:border-red-500 focus:ring-red-500/30 @else border-gray-300 focus:border-indigo-500 focus:ring-indigo-500/30 @enderror">

            @error('email')
                <p class="text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="flex flex-col gap-1.5">
        <label for="role" class="text-sm font-medium text-gray-700">Tipo de conta</label>
        <select id="role" name="role" required
            class="w-full rounded-lg border bg-white px-3.5 py-2.5 text-sm text-gray-900 shadow-sm outline-none transition focus:ring-2 @error('role') border-red-500 focus:border-red-500 focus:ring-red-500/30 @else border-gray-300 focus:border-indigo-500 focus:ring-indigo-500/30 @enderror">
            <option value="user" @selected(old('role', $user?->role ?? 'user') === 'user')>Usuário</option>
            <option value="admin" @selected(old('role', $user?->role ?? 'user') === 'admin')>Administrador</option>
        </select>

        @error('role')
            <p class="text-xs text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div class="grid gap-4 sm:grid-cols-2">
        <div class="flex flex-col gap-1.5">
            <label for="password" class="text-sm font-medium text-gray-700">
                {{ $user ? 'Nova senha' : 'Senha' }}
            </label>
            <input id="password" name="password" type="password"
                placeholder="{{ $user ? 'Deixe vazio para manter' : 'Crie uma senha' }}" autocomplete="new-password"
                @required(! $user)
                class="w-full rounded-lg border bg-white px-3.5 py-2.5 text-sm text-gray-900 placeholder-gray-400 shadow-sm outline-none transition focus:ring-2 @error('password') border-red-500 focus:border-red-500 focus:ring-red-500/30 @else border-gray-300 focus:border-indigo-500 focus:ring-indigo-500/30 @enderror">

            @error('password')
                <p class="text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex flex-col gap-1.5">
            <label for="password_confirmation" class="text-sm font-medium text-gray-700">
                Confirmar senha
            </label>
            <input id="password_confirmation" name="password_confirmation" type="password"
                placeholder="Repita a senha" autocomplete="new-password" @required(! $user)
                class="w-full rounded-lg border border-gray-300 bg-white px-3.5 py-2.5 text-sm text-gray-900 placeholder-gray-400 shadow-sm outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/30">
        </div>
    </div>

    @if ($user)
        <p class="rounded-lg bg-gray-50 px-4 py-3 text-xs text-gray-500">
            Preencha a senha apenas se desejar redefini-la. A senha atual será mantida caso o campo fique vazio.
        </p>
    @endif

    <div class="flex flex-col-reverse gap-3 border-t border-gray-100 pt-5 sm:flex-row sm:justify-end">
        <a href="{{ route('admin.users.index') }}"
            class="inline-flex items-center justify-center rounded-lg border border-gray-300 px-4 py-2.5 text-sm font-medium text-gray-600 transition hover:bg-gray-50">
            Cancelar
        </a>

        <button type="submit"
            class="inline-flex items-center justify-center rounded-lg bg-gray-900 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-gray-800">
            {{ $submitLabel }}
        </button>
    </div>
</form>
