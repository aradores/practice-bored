<div 
    x-data="{ 
        currentFees: @entangle('current_fees'),
        feeType: @entangle('type'), 
        invoice: @entangle('invoiceType'),
        rate: @entangle('rateType'),
        use_default: @entangle('use_default'),
        reason: @entangle('reason'),
        labels: { COMMISSION_FEE: 'Commission', CONVENIENCE_FEE: 'Convenience Fee' },
        isApproval: @entangle('isApproval'),

        openInvoice: false,
        setRate(type) {
            this.rate = type;
            $wire.rateType = type;
        },

        setInvoice(type) {
            this.invoice = type;
            $wire.invoiceType = type;
        },
        formModal: @entangle('formModal'),
        confirmationModal: @entangle('confirmModal'),
    }"
>
    <form wire:submit.prevent="save" class="transition-all duration-500">
        <div class="type flex flex-col md:flex-row"
            :class="isApproval ? 'gap-0' : 'gap-2.5' ">
            <template x-for="(fee, type) in currentFees" :key="type">
                <template x-if="@js(!$fee_id) || @js($type) === type">
                    <button 
                        type="button"
                        @click="feeType = type"
                        class="flex flex-col capitalize transition-all duration-300 w-full text-start mt-3"
                        :class="
                            isApproval
                                ? (feeType === type
                                    ? 'border-b-2 p-3 border-primary-700 text-primary-700 font-bold !text-center w-full'
                                    : 'border-b-2 p-3 border-rp-neutral-200 text-rp-neutral-700 !text-center w-full')
                                : (feeType === type
                                    ? 'p-3 border rounded-2xl text-primary-700 bg-primary-100 border-primary-700'
                                    : 'p-3 border rounded-2xl text-rp-neutral-600 bg-white border-rp-neutral-600 hover:bg-primary-100')
                        ">
                        <div x-show="isApproval != true">
                            <div class="label flex">
                                <x-icon.hand-cash width="16" height="16" stroke="currentColor" />
                                @if ($fee_id)
                                    <p class="ps-1 text-sm" x-text="'Current Rate'"></p>
                                @else
                                    <p class="ps-1 text-sm" x-text="feeType === type ? 'All' : type === 'MARKUP' ? 'Markup Rate' : 'Invoice'"></p>
                                @endif
                            </div>

                            <p class="text-2xl font-bold mt-1" x-text="fee.value"></p>

                            @if(isset($merchant))
                                <span class="text-xs mt-1" 
                                    x-text="fee.is_custom ? 'Uses Custom Rate ' + type : 'Uses Default'"></span>
                            @endif
                        </div>
                        <p x-show="isApproval == true" class="ps-1 text-sm" x-text="type === 'MARKUP' ? 'Markup Rate' : 'Invoice' "></p>
                    </button>
                </template>
            </template>
        </div>
        <div class="my-3"></div>
        <div class="md:w-72 flex flex-col gap-5 mt-5">
            @if (isset($merchant))
                <x-input.input-group class="flex !flex-row !flex-row-reverse gap-2 justify-end">
                    <x-input type="checkbox" wire:model="use_default" class="scale-150" id="default_checkbox"/>
                    <x-slot:label for="default_checkbox" >
                        Use Default <span x-text="feeType"></span>
                    </x-slot:label>
                </x-input.input-group>


                <div x-show="use_default" 
                     class="default_rates rounded bg-rp-blue-200 text-rp-blue-600 border border-rp-blue-600 p-1">
                    <span class="capitalize">Current <span x-text="feeType"></span> Rate: </span>
                    <span class="font-bold">60%</span>
                </div>
            @endif


            <div x-show="!use_default" class="fee-config">
                <div x-show="feeType === 'INVOICE'" class="relative w-full">
                    <button @click="openInvoice = !openInvoice"
                        type="button"
                        class="rounded-xl w-full flex justify-between items-center px-4 py-3 border bg-surface-alt">
                        <span x-text="labels[invoice]"></span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4">
                            <path stroke-width="2" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                        </svg>
                    </button>

                    <div x-show="openInvoice" @click.outside="openInvoice = false"
                        class="absolute z-20 w-full mt-1 bg-white border rounded-xl shadow-lg">
                        <template x-for="opt in ['COMMISSION_FEE','CONVENIENCE_FEE']">
                            <a href="#" 
                                @click.prevent="setInvoice(opt); openInvoice = false"
                                class="px-4 py-2 text-sm hover:bg-gray-100 block"
                                x-text="labels[opt]"></a>
                        </template>
                    </div>
                </div>

                <x-input.input-group>
                    <x-slot:label>Rate Type</x-slot:label>

                    <div class="rate_type_toggle bg-gray-200 rounded-lg p-1">
                        <div class="flex relative">

                            <div class="absolute bg-white rounded-md shadow-sm transition-all duration-300 w-1/2 h-full top-0"
                                 :style="rate === 'FLAT' ? 'margin-left: 50%' : 'margin-left: 0'">
                            </div>

                            <button type="button" class="z-10 flex-1 py-1.5"
                                @click="setRate('PERCENTAGE')">
                                % Percentage
                            </button>

                            <button type="button" class="z-10 flex-1 py-1.5"
                                @click="setRate('FLAT')">
                                ₱ Flat Rate
                            </button>
                        </div>
                    </div>
                </x-input.input-group>

                <x-input.input-group>
                    <x-slot:label>Amount</x-slot:label>

                    <div class="relative">
                        <template x-if="rate === 'FLAT'">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">₱</span>
                        </template>

                        <input type="number" wire:model="amount" min="0"
                            :class="rate === 'FLAT' ? 'pl-8 pr-3' : 'pl-3 pr-6 text-end'"
                            class="w-full border rounded-md py-2 text-sm"/>

                        <template x-if="rate === 'PERCENTAGE'">
                            <span class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-500">%</span>
                        </template>
                    </div>
                </x-input.input-group>
            </div>

            <div wire:ignore>
                <x-input.input-group>
                    <x-slot:label>Effective Date & Time</x-slot:label>
                    <x-date-picker.date-time-picker 
                        id="effective_date"
                        value="{{ $effective_date }}"
                        :minDateEnabled="true"
                        />
                    <span class="italic text-rp-red-500 text-xs mt-2 label">Date must be at least 30 days later</span>
                </x-input.input-group>
            </div>
        </div>

        <x-input.input-group>
            <x-slot:label>
                <span class="text-rp-red-600">*</span> Reason for Custom Rate Alteration
            </x-slot:label>

            <textarea x-model="reason" maxlength="1000"
                class="w-full border rounded-md p-2"></textarea>

            <div class="text-sm text-gray-500 text-right">
                <span x-text="reason.length"></span>/1000
            </div>
        </x-input.input-group>

        @if(!$merchant && !$fee_id)
        <x-input.input-group class="flex !flex-row !flex-row-reverse gap-2 justify-end">
            <x-slot:label for="apply_to_existing" >
                Apply to Existing
            </x-slot:label>
            <x-input type="checkbox" wire:model="apply_to_existing" id="apply_to_existing" />
        </x-input.input-group>
        @endif

        <div class="submit-button flex justify-end mt-6" x-data='{confirmModal : false}'>
            @if ($isApproval)
                <x-button.primary-gradient-button wire:ignore type="button" wire:click="confirmSave"
                    wire:loading.attr="disabled">
                    {{ $fee_id ? 'SAVE FEES' : 'SCHEDULE UPDATE' }}
                </x-button.primary-gradient-button>
            @else
                <x-button.primary-gradient-button wire:ignore type="button" @click="confirmModal = true"
                    wire:loading.attr="disabled">
                    {{ $fee_id ? 'SAVE FEES' : 'SCHEDULE UPDATE' }}
                </x-button.primary-gradient-button>
            @endif

            <x-modal x-model="confirmModal">
                <x-modal.confirmation-modal title="Schedule Fee" message="Are you sure you want to schedule this fee?">
                    <x-slot:action_buttons>
                        <x-button.outline-button class="w-1/2" wire:ignore type="button" color="primary" class="w-1/2" @click="confirmModal = false;">Cancel</x-button.outline-button>
                        <x-button.filled-button class="w-1/2" color="primary" type="submit"
                            wire:loading.attr="disabled">
                            {{ $fee_id ? 'SAVE FEES' : 'SCHEDULE UPDATE' }}
                        </x-button.filled-button>
                    </x-slot:action_buttons>
                </x-modal.confirmation-modal>
            </x-modal>
        </div>
    </form>
</div>

@push('styles')
    <style>
        label, .label{
            user-select: none;
        }
    </style>
@endpush