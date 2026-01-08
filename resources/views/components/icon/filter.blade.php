@props([
    'width' => 20,
    'height' => 21,
    'color' => '#42505A',
])

<svg xmlns="http://www.w3.org/2000/svg" width="{{ $width }}" height="{{ $height }}" viewBox="0 0 20 21" fill="none">
    <path d="M2.5 6.33337H17.5" stroke="{{ $color }}" stroke-width="1.5" stroke-linecap="round" />
    <path d="M5 10.5H15" stroke="{{ $color }}" stroke-width="1.5" stroke-linecap="round" />
    <path d="M8.3335 14.6666H11.6668" stroke="{{ $color }}" stroke-width="1.5" stroke-linecap="round" />
</svg>
