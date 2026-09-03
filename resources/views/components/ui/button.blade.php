@props([
    "type"      => "submit",
    "variant"   => "default"
])

@php
    $variants = [
        'default' => 'bg-white text-black hover:bg-white/80 focus-visible:outline-white',
        'primary' => 'bg-blue-500 text-white hover:bg-blue-400 focus-visible:outline-blue-500',
        'secondary' => 'bg-transparent text-white ring-1 ring-white/20 hover:bg-white/10',
        'danger' => 'bg-red-600 text-white hover:bg-red-500 focus-visible:outline-red-600',
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
