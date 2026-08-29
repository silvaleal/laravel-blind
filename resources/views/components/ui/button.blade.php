@props([
    "type"      => "submit",
    "variant"   => "default"
])

@php
    $variants = [
        'default' => 'bg-gray-900 text-white hover:bg-gray-800 focus-visible:outline-gray-900',
        'primary' => 'bg-blue-600 text-white hover:bg-blue-700 focus-visible:outline-blue-600',
        'secondary' => 'bg-white text-gray-700 ring-1 ring-gray-300 hover:bg-gray-50',
        'danger' => 'bg-red-600 text-white hover:bg-red-700 focus-visible:outline-red-600',
    ];

    $variantClass = $variants[$variant] ?? $variants['default'];
@endphp

<button
    {{ $attributes->class([
        'inline-flex w-full items-center justify-center rounded-lg px-4 py-2.5 text-sm font-semibold shadow-sm transition active:scale-[.98] focus-visible:outline-2 focus-visible:outline-offset-2',
        $variantClass,
    ]) }}
    type="{{ $type }}"
>{{ $slot }}</button>
