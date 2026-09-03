@props([
    'title' => 'Label',
    'placeholder',
    'variant' => 'default',
    'name' => "default-input-name",
    'type' => 'text',
])

@php
    $hasError = $errors->has($name);
    $variants = [
        'default' => 'border-white/10 bg-white/5 text-white focus:border-white/30 focus:ring-white/30 placeholder-white/30',
        'danger' => 'border-red-500/40 bg-red-500/10 focus:border-red-500 focus:ring-red-500',
    ];

    $variantClass = $variants[$variant] ?? $variants['default'];

    if ($hasError) {
        $variantClass = $variants['danger'];
    }
@endphp

<div class="flex flex-col gap-1.5">
    <label for="{{ $name }}" class="text-sm font-medium text-white/70">
        {{ $title }}
    </label>
    <input
        id="{{ $name }}"
        {{ $attributes->class([
            'w-full rounded-lg border px-3.5 py-2.5 text-sm text-white placeholder-white/30 shadow-sm outline-none transition focus:ring-2',
            $variantClass,
        ]) }}
        placeholder="{{ $placeholder ?? '' }}"
        type="{{ $type }}"
        name="{{ $name }}"
        value="{{ old($name) }}"
    >
    @error($name)
        <p class="text-xs text-red-400">{{ $message }}</p>
    @enderror
</div>
