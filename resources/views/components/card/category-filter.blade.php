@php
    $baseClass = 'flex flex-col justify-between gap-1 rounded-2xl px-5 py-4 w-full';

    $activeClass = !$isActive
        ? 'border border-rp-neutral-300'
        : 'border border-primary-700 bg-primary-100 text-primary-700';
@endphp

<div role="button" {{ $attributes->merge(['class' => $baseClass . ' ' . $activeClass]) }}>
    <div class="space-y-2">
        {{-- Icon & Title --}}
        <div class="flex flex-row gap-1 items-center text-sm">
            <div>
                <x-dynamic-component component="icon.{{ $icon }}" :color="$isActive ? '#6941C6' : '#90A1AD'" :stroke="$isActive ? '#6941C6' : '#90A1AD'" :fill="$isActive ? '#6941C6' : '#90A1AD'"
                    width="20" height="20" />

            </div>
            <span>{{ $title }}</span>
        </div>
        {{-- Count --}}
        <span class="text-2xl font-bold">{{ $count }}</span>
    </div>
    {{-- Amount --}}
    <div class="flex flex-row items-center justify-between text-xs">
        <span>{{ Number::currency($amount, 'PHP') }}</span>
        @if ($percent !== null)
            <div class="flex flex-row items-center gap-[1px] text-rp-green-600">
                <x-icon.solid-arrow-up fill="#149d8c" />
                {{-- mock --}}
                <span>{{ $percent }}%</span>
            </div>
        @endif
    </div>
</div>
