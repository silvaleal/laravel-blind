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
        'default' => 'border-gray-300 bg-white focus:border-blue-500 focus:ring-blue-500',
        'danger' => 'border-red-400 bg-red-50 focus:border-red-500 focus:ring-red-500',
    ];

    $variantClass = $variants[$variant] ?? $variants['default'];

    if ($hasError) {
        $variantClass = $variants['danger'];
    }
@endphp

<div class="flex flex-col gap-1.5">
    <label for="{{ $name }}" class="text-sm font-medium text-gray-700">
        {{ $title }}
    </label>
    <input
        id="{{ $name }}"
        {{ $attributes->class([
            'w-full rounded-lg border px-3.5 py-2.5 text-sm text-gray-900 placeholder-gray-400 shadow-sm outline-none transition focus:ring-2',
            $variantClass,
        ]) }}
        placeholder="{{ $placeholder ?? '' }}"
        type="{{ $type }}"
        name="{{ $name }}"
        value="{{ old($name) }}"
    >
    @error($name)
        <p class="text-xs text-red-600">{{ $message }}</p>
    @enderror
</div>
