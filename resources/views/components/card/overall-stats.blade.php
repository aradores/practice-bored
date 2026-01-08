<div {{ $attributes->merge(['class' => "relative p-6 bg-primary-100 border border-primary-700 text-primary-700 rounded-2xl w-full flex flex-col overflow-hidden"]) }}>
    <span>{{ $title }}</span>
    <div class="flex flex-col w-max">
        <div class="flex flex-row gap-4 justify-between items-center">
            <span class="font-bold text-3xl">{{ Number::currency($current_amount, 'PHP') }}</span>
            @if ($direction === 'down') 
                <div class="flex flex-row items-center justify-center gap-1 bg-red-600 text-white text-sm py-1 px-2 rounded-3xl w-max">
                    <x-icon.solid-arrow-down fill="#ffffff" />
                    <span>{{ $percent }}%</span>
                </div>
            @elseif ($direction === 'up')
                <div class="flex flex-row items-center justify-center gap-1 bg-rp-green-600 text-white text-sm py-1 px-2 rounded-3xl w-max">
                    <x-icon.solid-arrow-up fill="#ffffff" />
                    <span>{{ $percent }}%</span>
                </div>
            @endif
        </div>
        @if ($previous_amount !== null)
            <div class="flex flex-row gap-4 justify-between items-center text-sm">
                <span>vs. previous period</span>
                <span>{{ Number::currency($previous_amount, 'PHP') }}</span>
            </div>
        @endif
    </div>

    {{-- Icon --}}
    <div class="absolute top-0 right-0">
        <img src="{{ url('images/purple-wallet.png') }}" />
    </div>
</div>