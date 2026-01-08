<div class="w-96 mx-auto p-6 bg-white rounded-2xl shadow-lg">
    <!-- Header -->
    <div class="flex justify-between items-start mb-8">
        <h2 class="text-xl font-semibold text-gray-800">Transaction Details</h2>
        {{-- Handle dispatch on parent to close --}}
        <button class="text-gray-500 hover:text-gray-700" @click="$dispatch('txn-detail-close')">
            <x-icon.close-no-border :width="22" :height="22" />
        </button>
    </div>

    <p class="text-center text-lg font-semibold text-purple-600 mb-4 italic">
        {{ $transaction->type->name }}
    </p>

    <!-- Recipient Info -->
    <div class="text-center text-sm text-gray-700 mb-6">
        <p class="text-sm text-gray-600">Sent to:</p>
        @switch(get_class($transaction->recipient))
            @case('App\Models\User')
                <p class="text-lg font-bold text-gray-800">{{ $this->mask_name($transaction->recipient->name) }}</p>
                <p>{{ $this->mask_phone_number($transaction->recipient->phone_number) }}</p>
            @break

            @default
                <p>{{ $transaction->recipient->name }}</p>
        @endswitch
        <p class="text-sm text-gray-600">Destination: {{ $transaction->channel->name }}</p>
    </div>

    <div class="flex justify-between items-center mb-2">
        <span class="text-gray-700">Status</span>
        <x-transaction.status-pill status="{{ $transaction->status->slug }}" />
    </div>

    <div class="flex justify-between mb-1">
        <span class="text-gray-700">Amount</span>
        <span class="text-gray-800 font-medium">
            {{ Number::currency($transaction->amount, $transaction->currency) }}
        </span>
    </div>

    <div class="flex justify-between mb-1">
        <span class="text-gray-700">Convenience Fee</span>
        <span class="text-gray-800 font-medium">
            {{ Number::currency($transaction->service_fee + $transaction->repay_cut, $transaction->currency) }}
        </span>
    </div>

    <div class="flex justify-between items-center mb-4">
        <span class="text-gray-900 font-semibold text-lg">Total</span>
        <span class="text-gray-900 font-bold text-xl">
            {{ Number::currency($transaction->service_fee + $transaction->repay_cut + $transaction->amount, $transaction->currency) }}
        </span>
    </div>

    {{-- TODO: Apply conditional visibility for transaction request --}}
    <div class="flex justify-between text-sm font-medium text-gray-600 mb-2">
        <p>Reference No: </p>
        <p>{{ $transaction->ref_no }}</p>
    </div>

    {{-- TODO: Apply conditional visibility for transaction request --}}
    <div class="flex justify-between text-sm font-medium text-gray-600 mb-2">
        <p>Transaction No: </p>
        <p>{{ $transaction->txn_no }}</p>
    </div>

    <div class="flex justify-between text-sm font-medium text-gray-600 mb-10">
        <p>Date created: </p>
        <p>{{ $transaction->created_at->timezone('Asia/Manila')->format('F d, Y h:i A') }}</p>
    </div>

    {{-- TODO: Apply conditional visibility for transaction request status --}}
    <div class="flex justify-between text-sm font-medium text-gray-600">
        <p>Date [rejected/accepted]: </p>
        <p>{{ $transaction->created_at->timezone('Asia/Manila')->format('F d, Y h:i A') }}</p>
    </div>

    <hr class="mt-4 mb-6" />

    <!-- History -->
    <p class="text-center text-purple-600 font-semibold italic text-lg mb-4">History</p>

    {{-- TODO: Apply conditional visibility if transaction undergoes a transaction request process --}}
</div>
