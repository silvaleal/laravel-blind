@props([
    'role',
])

@php
    $isAdmin = $role === 'admin';

    $classes = $isAdmin
        ? 'bg-indigo-50 text-indigo-700 ring-indigo-200'
        : 'bg-gray-100 text-gray-600 ring-gray-200';

    $label = $isAdmin ? 'Administrador' : 'Usuário';
@endphp

<span {{ $attributes->class(['inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium ring-1 ring-inset', $classes]) }}>
    {{ $label }}
</span>
