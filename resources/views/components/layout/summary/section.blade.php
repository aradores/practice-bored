@props([
    'title' => null,
    'color' => 'red',
])

@php 
    $colors = [
        'primary' => 'text-primary-600',
        'red' => 'text-rp-red-500' 
    ];

@endphp
<div>
    @if ($title && empty($titleHeaders))     
        <h3 class="text-[19.2px] font-bold mb-3 w-full {{ $colors[$color] }}">{{ $title }}</h3>
    @endif
    @if (!empty($titleHeaders))
        <div class="flex justify-between items-center mb-3">
            <div>
                <h3 class="text-[19.2px] font-bold {{ $colors[$color] }}">{{ $title }}</h3>
            </div>
            {{ $titleHeaders }}
        </div>
    @endif
    <div>
        {{ $data }}
    </div>
</div>