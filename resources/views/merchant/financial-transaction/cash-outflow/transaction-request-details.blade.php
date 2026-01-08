<div class="w-[471px] p-5 bg-white rounded-2xl border border-rp-neutral-100">
    {{-- Header --}}
    <div class="flex justify-between items-start mb-6">
        <h2 class="text-2xl font-bold text-rp-neutral-700">Transaction Details</h2>
        {{-- Handle dispatch on parent to close --}}
        <button class="text-rp-neutral-500 hover:text-rp-neutral-700" @click="$dispatch('closeTransactionDetails')">
            <x-icon.close-no-border :width="22" :height="22" />
        </button>
    </div>

    <div class="py-5 flex flex-col gap-5 border-b-[1.5px] border-rp-neutral-100 mb-3">
        <p class="text-center text-xl font-bold text-primary-600 italic">
            {{ $transaction_request->type->name }}
        </p>

        {{-- Recipient Info --}}
        <div class="flex flex-col gap-4">
            <div class="text-center text-rp-gray-800">
                <p class="text-sm">Send to:</p>
                <p class="text-lg font-bold">
                    {{ $transaction_request->recipient_display_name ?? $transaction_request->recipient_name }}</p>
                <p>{{ isset($transaction_request->recipient_display_name) ? $transaction_request->recipient_name : '' }}
                </p>
                <p class="text-sm">Destination: {{ $transaction_request->destination_name }}</p>
            </div>

            <div class="text-rp-gray-800">
                <div class="flex justify-between items-center text-sm py-1">
                    <span>Status</span>
                    @if ($transaction_request->status->slug() == 'pending approval')
                        <x-transaction.status-pill class="!w-44" :status="$transaction_request->status->slug()" />
                    @else
                        <x-transaction.status-pill :status="$transaction_request->status->slug()" />
                    @endif
                </div>

                <div class="flex justify-between items-center text-sm py-1">
                    <span>Amount</span>
                    <span>
                        {{ Number::currency($transaction_request->amount, $transaction_request->currency) }}
                    </span>
                </div>

                <div class="flex justify-between items-center text-sm py-1">
                    <span>Service Fee</span>
                    <span>
                        {{ Number::currency($transaction_request->service_fee + $transaction_request->repay_cut, $transaction_request->currency) }}
                    </span>
                </div>

                <div class="flex justify-between items-center font-bold py-1">
                    <span class="text-sm">Total</span>
                    <span class="text-2xl">
                        {{ Number::currency($transaction_request->total_amount, $transaction_request->currency) }}
                    </span>
                </div>

                <div class="flex justify-between text-sm py-1">
                    <span>Date created</span>
                    <span>{{ $transaction_request->created_at->timezone('Asia/Manila')->format('F d, Y h:i A') }}</span>
                </div>
            </div>
        </div>

    </div>

    {{-- History --}}
    <div class="py-5 mb-3">
        <p class="text-center text-primary-600 font-bold italic text-xl mb-5">History</p>
        @include('components.ui.transaction-logs')
    </div>

    @if ($transaction_request->status->slug() == 'pending approval')
        {{-- Approve/Reject --}}
        <div class="flex flex-col gap-2.5 mb-2.5">
            <x-button.filled-button color="red" class="!border" @click="$wire.dispatch('showTransactionRequestToApprove', {id:'{{ $transaction_request->id }}'})">approve</x-button.filled-button>
            <x-button.outline-button color="red" class="!border" @click="$wire.dispatch('showTransactionRequestToReject', {id:'{{ $transaction_request->id }}'})">reject</x-button.outline-button>
        </div>
    @endif

    <div class="flex justify-center gap-2.5 items-center text-xs text-rp-gray-800 py-3">
        <span>Powered by:</span>
        <img src="{{ url('/images/repay-logo-colored.png') }}" class="h-6" alt="RePay logo" />
    </div>
</div>
