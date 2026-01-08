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
        <strong class="text-base font-bold mb-3 block w-full {{ $colors[$color] }}">{{ $title }}</strong>
    @endif
    @if (!empty($titleHeaders))
        <div class="flex justify-between items-center mb-3">
            <div>
                <strong class="text-base font-bold {{ $colors[$color] }}">{{ $title }}</strong>
            </div>
            {{ $titleHeaders }}
        </div>
    @endif
    <div {{ $data->attributes }}>
        {{ $data }}
    </div>
</div>