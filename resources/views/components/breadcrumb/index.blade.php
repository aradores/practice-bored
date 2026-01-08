@props([
    'items' => []
])
<div {{ $attributes->merge(['class' => "flex flex-row items-center gap-2"]) }}>
    @foreach ($items as $item)
        @if ($loop->index > 0) 
            <x-icon.solid-arrow-right />
        @endif
        <a href="{{ !isset($item['href']) ? '/' : $item['href'] }}" class="{{ !isset($item['href']) ? 'cursor-default text-rp-neutral-500 pointer-events-none' : 'hover:underline text-rp-neutral-600' }} font-bold">{{ $item['label']}}</a>
    @endforeach
</div>