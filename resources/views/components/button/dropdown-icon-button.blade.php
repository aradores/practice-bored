@props(['icon', 'title', 'width'])

@php
    $base_class = "flex justify-between items-center text-rp-neutral-700 px-4 py-2 border border-rp-neutral-500 bg-white rounded-lg duration-300 transition focus-within:ring-1";
@endphp

<button type="button"
    {{ $attributes->merge(['class' => "$base_class w-$width"]) }}>
    <div class="flex items-center gap-2">
        <x-dynamic-component component="icon.{{ $icon }}" width="20" height="20" color="#647887"
            fill="#647887" stroke="#647887" />
        <span class="text-sm">{{ $title }}</span>
    </div>
    <div>
        <x-icon.thin-arrow-down />
    </div>
</button>