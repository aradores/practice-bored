@props([
    'icon' => null,
    'label' => '',
    'description' => '',
    'isActive' => false
])

@php
    $activeClass = $isActive ? 'border border-primary-600 bg-primary-100' : 'border border-rp-neutral-300 bg-white';
@endphp

<div {{ $attributes->merge(['class' => 'rounded-xl flex flex-row p-3 gap-1 ' . $activeClass])}}>
    <div>
        @if (!empty($icon))
            <x-dynamic-component component="icon.{{ $icon }}" fill="{{ $isActive ? '#7F56D9' : '#647887' }}" stroke="{{ $isActive ? '#7F56D9' : '#647887' }}" />
        @endif
    </div>
    <div class="flex flex-col">
        <strong class="{{ $isActive ? 'text-primary-600' : 'text-rp-neutral-600' }}">{{ $label }}</strong>
        <span class="{{ $isActive ? 'text-primary-500' : 'text-rp-neutral-600'}}">{{ $description }}</span>
    </div>
</div>