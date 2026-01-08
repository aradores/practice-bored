<div class="w-[431px] p-5 bg-white rounded-2xl border border-rp-neutral-100">
    <div class="flex justify-between items-start mb-6">
        <h2 class="text-2xl font-bold text-rp-neutral-700">Details</h2>
        {{-- Handle dispatch on parent to close --}}
        <button class="text-rp-neutral-500 hover:text-rp-neutral-700" @click="$dispatch('closePayrollDetails')">
            <x-icon.close-no-border :width="22" :height="22" />
        </button>
    </div>

    <div class="py-5 flex flex-col gap-5">
        <p class="text-center text-xl font-bold text-primary-600 italic">
            Payroll
        </p>

        <div class="flex flex-col gap-4 text-rp-gray-800 border-b-[1.5px] pb-5 border-rp-neutral-100">
            <div class="text-center text-sm">
                <p>{{ $payroll->status->slug() === 'processed' ? 'Sent' : 'Send' }} to:</p>
                <p class="font-bold text-xl">{{ $this->recipient_name }}</p>
                <p>{{ $this->recipient_phone_number }}</p>
                <p>Destination: Repay</p>
            </div>

            <div class="flex flex-col gap-2">
                <div class="flex justify-between items-center">
                    <span class="text-sm">Status</span>
                    <x-transaction.status-pill status="{{ $payroll->status->slug() }}" />
                </div>

                <div class="flex justify-between">
                    <span class="text-sm">Amount</span>
                    <span class="text-sm">{{ Number::currency($payroll->gross_pay, 'PHP') }}</span>
                </div>

                <div class="flex justify-between">
                    <span class="text-sm">Deductions</span>
                    <span class="text-sm">{{ Number::currency($payroll->deductions * -1, 'PHP') }}</span>
                </div>

                <div class="flex justify-between items-center font-bold my-2">
                    <span class="text-sm">Total</span>
                    <span class="text-2xl">{{ Number::currency($payroll->net_salary, 'PHP') }}</span>
                </div>

                @if ($payroll->transaction)
                    <div class="flex justify-between text-sm">
                        <span>Reference No:</span>
                        <span>{{ $payroll->transaction->ref_no }}</span>
                    </div>
                @endif

                <div class="flex justify-between text-sm">
                    <p>Date Created:</p>
                    <p>{{ \Carbon\Carbon::parse($payroll->created_at)->timezone('Asia/Manila')->format('F d, Y - h:i A') }}
                    </p>
                </div>

                @if (in_array($payroll->status->slug(), ['processed', 'scheduled', 'rejected']))
                    <div class="flex justify-between text-sm">
                        <p>Date {{ $payroll->status->slug() === 'rejected' ? 'Rejected' : 'Approved' }}:</p>
                        <p>
                            {{ \Carbon\Carbon::parse($this->processed_at)->timezone('Asia/Manila')->format('F d, Y - h:i A') }}
                        </p>
                    </div>
                @endif
            </div>
        </div>

        {{-- History --}}
        @if ($this->logs->isNotEmpty())
            <div class="pb-3">
                <p class="text-center text-primary-600 font-bold italic text-xl mb-5">History</p>
                @include('merchant.financial-transaction.payroll.components.payroll-request-logs')
            </div>
        @endif

        @if ($can_approve)
            @if ($payroll->status->slug() === 'pending')
                <div class="flex flex-col gap-2.5">
                    <x-button.filled-button color="red" class="!border"
                        wire:click="$parent.showApproveModal('{{ $payroll->id }}')">approve</x-button.filled-button>
                    <x-button.outline-button color="red" class="!border"
                        wire:click="$parent.showRejectModal('{{ $payroll->id }}')">reject</x-button.outline-button>
                </div>
            @elseif ($payroll->status->slug() === 'failed')
                <x-button.filled-button color="red" class="!border"
                    wire:click="$parent.showRetryFailedModal('{{ $payroll->id }}')">retry failed
                    schedule</x-button.filled-button>
            @endif
        @endif


        <div class="flex justify-center gap-2.5 items-center text-xs text-rp-gray-800 py-3">
            <span>Powered by:</span>
            <img src="{{ url('/images/repay-logo-colored.png') }}" class="h-6" alt="RePay logo" />
        </div>
    </div>
</div>
