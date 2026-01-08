<div class="w-[471px] p-5 bg-white rounded-2xl border border-rp-neutral-100">
    <div class="flex justify-between items-start mb-6">
        <h2 class="text-2xl font-bold text-rp-neutral-700">Transaction Details</h2>
        {{-- Handle dispatch on parent to close --}}
        <button class="text-rp-neutral-500 hover:text-rp-neutral-700" @click="$dispatch('txn-detail-close')">
            <x-icon.close-no-border :width="22" :height="22" />
        </button>
    </div>

    <div class="py-5 flex flex-col gap-5">
        <p class="text-center text-xl font-bold text-primary-600 italic">
            {{ $transaction->type->name }}
        </p>

        <div class="flex flex-col gap-4 text-rp-gray-800">
            <div class="text-center text-sm">
                <p>Sent from</p>
                <p class="font-bold">{{ $transaction->sender_name }}</p>
            </div>

            <div class="flex flex-col gap-2">
                <div class="flex justify-between items-center">
                    <span class="text-sm">Status</span>
                    <x-transaction.status-pill status="{{ $transaction->status->slug }}" />
                </div>

                <div class="flex justify-between">
                    <span class="text-sm">Amount</span>
                    <span class="text-sm">
                        {{ Number::currency($transaction->amount, $transaction->currency) }}
                    </span>
                </div>

                <div class="flex justify-between">
                    <span class="text-sm">Convenience Fee</span>
                    <span class="text-sm">
                        {{ Number::currency($transaction->service_fee + $transaction->repay_cut, $transaction->currency) }}
                    </span>
                </div>

                <div class="flex justify-between items-center font-bold my-2">
                    <span class="text-sm">Total</span>
                    <span class="text-2xl">
                        {{ Number::currency($transaction->service_fee + $transaction->repay_cut + $transaction->amount, $transaction->currency) }}
                    </span>
                </div>

                <div class="flex justify-between text-sm">
                    <span>Reference No:</span>
                    <span>{{ $transaction->ref_no }}</span>
                </div>

                <div class="flex justify-between text-sm">
                    <p>Transaction No: </p>
                    <p>{{ $transaction->txn_no }}</p>
                </div>

                <div class="flex justify-between text-sm">
                    <p>Date: </p>
                    <p>{{ $transaction->created_at->timezone('Asia/Manila')->format('F j, Y h:i A') }}</p>
                </div>
            </div>
        </div>

        <div class="flex justify-center gap-2.5 items-center text-xs text-rp-gray-800">
            <span>Powered by:</span>
            <img src="{{ url('/images/repay-logo-colored.png') }}" class="h-6" alt="RePay logo" />
        </div>
    </div>
</div>
