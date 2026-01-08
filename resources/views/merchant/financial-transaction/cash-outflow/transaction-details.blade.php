<div class="w-[471px] p-5 bg-white rounded-2xl border border-rp-neutral-100" wire:ignore>
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
            {{ $transaction->type->name }}
        </p>

        {{-- Recipient Info --}}
        <div class="flex flex-col gap-4">
            <div class="text-center text-rp-gray-800">
                <p class="text-sm">Send to:</p>
                <p class="text-lg font-bold">
                    {{ $transaction->recipient_name }}</p>
                </p>
                <p class="text-sm">Destination: {{ $transaction->destination_name }}</p>
            </div>

            <div class="text-rp-gray-800">
                <div class="flex justify-between items-center text-sm py-1">
                    <span>Status</span>
                    <x-transaction.status-pill :status="$transaction->status->slug" />
                </div>

                <div class="flex justify-between items-center text-sm py-1">
                    <span>Amount</span>
                    <span>
                        {{ Number::currency($transaction->amount, $transaction->currency) }}
                    </span>
                </div>

                <div class="flex justify-between items-center text-sm py-1">
                    <span>Service Fee</span>
                    <span>
                        {{ Number::currency($transaction->service_fee + $transaction->repay_cut, $transaction->currency) }}
                    </span>
                </div>

                <div class="flex justify-between items-center font-bold py-1">
                    <span class="text-sm">Total</span>
                    <span class="text-2xl">
                        {{ Number::currency($transaction->total_amount, $transaction->currency) }}
                    </span>
                </div>

                <div class="flex justify-between text-sm py-1">
                    <span>Reference Number</span>
                    <span>{{ $transaction->ref_no }}</span>
                </div>

                <div class="flex justify-between text-sm py-1">
                    <span>Transaction Number</span>
                    <span>{{ $transaction->txn_no }}</span>
                </div>

                <div class="flex justify-between text-sm py-1">
                    <span>Date created</span>
                    <span>{{ $transaction->created_at->timezone('Asia/Manila')->format('F d, Y h:i A') }}</span>
                </div>
            </div>
        </div>

    </div>

    {{-- History --}}
    @if (!empty($this->logs))
        <div class="py-5 mb-3">
            <p class="text-center text-primary-600 font-bold italic text-xl mb-5">History</p>
            @include('components.ui.transaction-logs')
        </div>
    @endif

    <div class="flex justify-center gap-2.5 items-center text-xs text-rp-gray-800 py-3">
        <span>Powered by:</span>
        <img src="{{ url('/images/repay-logo-colored.png') }}" class="h-6" alt="RePay logo" />
    </div>
</div>
