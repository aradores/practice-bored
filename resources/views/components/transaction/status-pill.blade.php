@props([
    'status' => 'pending',
])

@php
    $status_css = match ($status) {
        'successful' => 'border-rp-green-600 bg-rp-green-200 text-rp-green-600',
        'processed' => 'border-rp-green-600 bg-rp-green-200 text-rp-green-600',
        'pending' => 'border-rp-yellow-600 bg-rp-yellow-200 text-rp-yellow-600',
        'pending approval' => 'border-rp-yellow-600 bg-rp-yellow-200 text-rp-yellow-600',
        'failed' => 'border-rp-red-600 bg-rp-red-200 text-rp-red-600',
        'rejected' => 'border-rp-red-600 bg-rp-red-200 text-rp-red-600',
        'refunded' => 'border-rp-blue-600 bg-rp-blue-200 text-rp-blue-600',
        'scheduled' => 'border-rp-blue-600 bg-rp-blue-200 text-rp-blue-600',
    };
@endphp

<div
    {{ $attributes->merge(['class' => 'border text-sm px-3 py-1 rounded-md flex justify-between items-center w-32 ' . $status_css]) }}>
    <span>{{ ucwords($status) }}</span>
    @switch($status)
        @case('successful')
        @case('processed')
            <x-icon.check width="18" height="18" />
        @break

        @case('pending')
        @case('pending approval')
            <x-icon.clock width="18" height="18" color="#DC6803" />
        @break

        @case('failed')
            <x-icon.warning width="18" height="18" color="#F70068" />
        @break

        @case('refunded')
            <x-icon.check width="18" height="18" fill="#1C7EBF" />
        @break

        @case('scheduled')
            <x-icon.calendar width="18" height="18" color="#1C7EBF" />
        @break
        
        @case('rejected')
            <x-icon.ban width="18" height="18" color="#F70068" />
        @break

        @default
    @endswitch
</div>
