@props([
    'color' => 'rp-red',
    'title',
    'icon',
    'left_icon'
])

@php
    $icon_color = match ($color) {
        'rp-red' => '#FF3D8F',
        'primary' => '#9E77ED',
    };
@endphp

<button
    {{ $attributes->merge(['class' => 'flex flex-row items-center rounded-lg border border-' . $color . '-500 divide-x divide-' . $color . '-500 text-' . $color . '-500 duration-300 transition focus:ring-2 focus:outline-none disabled:bg-rp-neutral-200 disabled:border-rp-neutral-200']) }}>
    <div class="{{ isset($left_icon) ? 'flex flex-row items-center gap-1' : '' }} p-2.5 text-sm font-bold uppercase">
        @if (isset($left_icon))
            <x-dynamic-component :component="$left_icon" :color="$icon_color"  width="16" height="16" />
        @endif
        {{ $title }}
    </div>
    <div class="p-2.5"><x-dynamic-component :component="$icon" :color="$icon_color" /></div>
</button>
