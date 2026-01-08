@props([
    'balance' => 0,
    'outflow' => 0,
    'direction' => 'row',
])

@php
    $balance_after_outflow = $balance - $outflow;
@endphp

<div {{ $attributes->merge(['class' => "relative py-6 pl-6 pr-36 bg-primary-100 border border-primary-700 rounded-2xl w-full flex flex-col overflow-hidden"]) }}>
    <div class="flex {{ $direction === 'row' ? 'flex-row justify-between max-w-[80%]' : 'flex-col' }}">
        {{-- Available balance: --}}
        <div class="flex {{ $direction === 'row' ? 'flex-col' : 'flex-row items-center' }}  text-primary-700 gap-3">
            <span class="text-base">Available Balance:</span>
            <strong class="text-xl">{{ Number::currency($balance, 'PHP') }}</strong>
        </div>
        {{-- Estimated Total Outflow: --}}
        <div class="flex {{ $direction === 'row' ? 'flex-col' : 'flex-row items-center' }} text-rp-red-600 gap-3">
            <span class="{{  $direction === 'row' ? 'text-base' : 'text-sm' }}">Estimated Total Outflow:</span>
            <strong class="{{ $direction === 'row' ? 'text-xl' : 'text-sm' }}">-{{ Number::currency($outflow, 'PHP') }}</strong>
        </div>
        {{-- Available balance After Outflow: --}}
        <div class="flex {{ $direction === 'row' ? 'flex-col' : 'flex-row items-center' }} text-primary-700 gap-3">
            <span class="{{  $direction === 'row' ? 'text-base' : 'text-sm' }}">Available Balance After Outflow:</span>
            <strong class="{{ $direction === 'row' ? 'text-xl' : 'text-sm' }}">{{ Number::currency($balance_after_outflow, 'PHP') }}</strong>
        </div>
    </div>
    {{-- Icon --}}
    <div class="absolute top-0 right-0">
        <img src="{{ url('images/purple-wallet.png') }}" />
    </div>
</div>