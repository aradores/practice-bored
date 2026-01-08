@props([
    'transactionDetails',
    'titleColor' => 'red',
])

@php
    $titleColors = [
        'red' => 'text-rp-red-600',
        'primary' => 'text-primary-600'
    ];

@endphp

<div class="bg-white py-6 mt-7 rounded-lg w-full">
    <div class="w-[80%] mx-auto">
        <h3 class="{{ $titleColors[$titleColor] }} text-lg font-bold italic text-center">{{ $transactionDetails['transaction_type'] }}</h3>
        <div class="leading-3 py-5 text-center">
            <span>{{ $transactionDetails['label'] }}</span>
            <p class="text-lg font-bold">{{ $transactionDetails['entity_name'] }}</p>
            <span class="text-sm">{{ $transactionDetails['phone_number'] }}</span>
        </div>
        @isset($transactionDetails['account_name'])
            <div class="flex flex-row place-items-center justify-between py-1">
                <span>Account Name</span>
                <span>{{ $transactionDetails['account_name'] }}</span>
            </div>
        @endisset
        <div class="flex flex-row place-items-center justify-between py-1">
            <span>Amount</span>
            <span>{{ \Number::currency($transactionDetails['amount'], $transactionDetails['currency']) }}</span>
        </div>
        @if (isset($transactionDetails['service_fee']) && $transactionDetails['service_fee'] > 0)
            <div class="flex flex-row place-items-center justify-between py-1">
                <span>Service Fee</span>
                <span>{{ \Number::currency($transactionDetails['service_fee'], $transactionDetails['currency']) }}</span>
            </div>
        @endif
        <div class="flex flex-row justify-between">
            <span class="font-bold">Total</span>
            <span class="text-lg font-bold">{{ \Number::currency($transactionDetails['total_amount'], $transactionDetails['currency']) }}</span>
        </div>
        <div class="mt-3">
            <p class="text-center text-sm">Transaction Number: {{ $transactionDetails['txn_no'] }}</p>
            @isset($transactionDetails['refund_for'])
                <p class="text-center text-sm">Refund for Transaction Number: {{ $transactionDetails['refund_for'] }}</p>
            @endisset
            <p class="text-center text-sm">{{ $transactionDetails['created_at'] }}</p>
        </div>
    </div>
</div>