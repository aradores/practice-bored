<div class="w-full flex flex-row" x-data="cashOutflowIndex">
    <div class="py-10 px-4 min-w-[calc(100%-511px)] w-full"
        :class="{ 'border-r border-rp-neutral-100': show_transaction_details }">
        <div class="flex flex-row items-center justify-between text-neutral-700">
            <h1 class="font-bold text-rp-neutral-700 text-2xl">Cash Outflow</h1>
            <div class="flex flex-row items-center gap-2.5">
                {{-- Date picker --}}
                <x-date-picker.date-range-picker :from="$from_date" :to="$to_date" id="list" />

                {{-- Create button --}}
                <div id="create-card" class="flex flex-row items-stretch" x-data="{ show_create_dropdown: false }">
                    <a href="{{ route('merchant.financial-transactions.cash-outflow.create', ['merchant' => $merchant]) }}"
                        class="flex items-center rounded-tl-lg rounded-bl-lg bg-rp-red-500 hover:bg-rp-red-600 text-white text-sm font-bold uppercase p-2.5 border-r border-white"
                        :class="{ 'bg-rp-red-600': show_create_dropdown }">
                        Create
                    </a>
                    <div class="relative flex items-stretch" @click.away="show_create_dropdown=false">
                        <button @click="show_create_dropdown=!show_create_dropdown"
                            class="flex items-center rounded-tr-lg rounded-br-lg bg-rp-red-500 hover:bg-rp-red-600 text-white p-2.5 border-r border-white"
                            :class="{ 'bg-rp-red-600': show_create_dropdown }">
                            <x-icon.triangle-down width="16" height="16" color="#ffffff" />
                        </button>
                        <div x-cloak x-show="show_create_dropdown"
                            class="absolute mt-1 top-10 right-0 z-10 shadow-md bg-white rounded-lg flex flex-col w-72 text-sm">
                            <a href="{{ route('merchant.financial-transactions.cash-outflow.create', ['merchant' => $merchant, 'type' => 'money-transfer']) }}"
                                class="p-3 text-rp-neutral-500 hover:bg-rp-neutral-100">Money Transfer</a>
                            <a href="{{ route('merchant.financial-transactions.cash-outflow.create', ['merchant' => $merchant, 'type' => 'bill-payment']) }}"
                                class="p-3 text-rp-neutral-500 hover:bg-rp-neutral-100">Bills Payment</a>
                        </div>
                    </div>
                </div>

                {{-- Export button --}}
                <div id="export-card" class="relative">
                    <x-button.outline-icon-button title="Export" icon="icon.send-square" color="rp-red"
                        @click="show_export_form=!show_export_form" />
                    <div x-cloak x-show="show_export_form" class="absolute mt-1 right-0 z-10">
                        <livewire:merchant.financial-transaction.cash-outflow.cash-outflow-export :$merchant />
                    </div>
                </div>

            </div>
        </div>

        <div class="my-5">
            <x-card.overall-stats title="Money Sent" :currentAmount="$this->present_money_sent" :previousAmount="$this->previous_money_sent" />
        </div>

        <div class="flex flex-row gap-10 mb-4 justify-between">
            <div class="flex flex-1 border-b border-rp-neutral-100">
                <div class="flex justify-between items-center gap-2">
                    <button wire:click="$set('status', 'pending')"
                        class="w-36 py-2.5 text-sm {{ $this->status === 'pending' ? 'border-b-2 border-primary-700 text-primary-700 font-bold' : 'text-rp-neutral-700' }}">
                        Pending
                    </button>
                    <button wire:click="$set('status', 'approved')"
                        class="w-36 py-2.5 text-sm {{ $this->status === 'approved' ? 'border-b-2 border-primary-700 text-primary-700 font-bold' : 'text-rp-neutral-700' }}">
                        Approved
                    </button>
                    <button wire:click="$set('status', 'rejected')"
                        class="w-36 py-2.5 text-sm {{ $this->status === 'rejected' ? 'border-b-2 border-primary-700 text-primary-700 font-bold' : 'text-rp-neutral-700' }}">
                        Rejected
                    </button>
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                {{-- Search --}}
                <x-input.search wire:model.live="search_term" icon_position="left" placeholder="Search Recipient" />

                {{-- Dropdown Filters --}}
                <div class="relative" @click.outside="show_filters_dropdown=false">
                    <x-button.dropdown-icon-button icon="funnel" title="Filters" width="36"
                        @click="show_filters_dropdown=!show_filters_dropdown" />
                    <div x-cloak x-show="show_filters_dropdown"
                        class="absolute bg-white shadow-md rounded-lg right-0 p-5 flex flex-col gap-2">
                        {{-- Requested by --}}
                        <div class="relative" @click.outside="show_requested_by_dropdown=false">
                            <x-button.dropdown-icon-button icon="user-octagon-outline" title="Requested by"
                                @click="show_requested_by_dropdown=!show_requested_by_dropdown" width="52" />
                            <div x-show="show_requested_by_dropdown">
                                <livewire:merchant.financial-transaction.components.requestor-selection :$merchant
                                    :event_id="$event_requested_by" :has_clear_button="true" wire:key="filter-requested-by" />
                            </div>
                        </div>
                        {{-- Amount Range --}}
                        <div class="relative" @click.away="show_amount_range_dropdown=false">
                            <x-button.dropdown-icon-button icon="filter" title="Amount Range" width="52"
                                @click="show_amount_range_dropdown=!show_amount_range_dropdown" />
                            <div x-cloak x-show="show_amount_range_dropdown"
                                class="absolute top-[100%] mt-1 bg-white px-3 py-4 border shadow-md w-96 right-0 rounded-xl z-20">
                                <div class="flex flex-col gap-2 mb-4">
                                    <x-input.input-group>
                                        <x-slot:label>From</x-slot:label>
                                        <x-input type="text" placeholder="0.00" x-mask:dynamic="$money($input)"
                                            x-model="amount_min" />
                                    </x-input.input-group>
                                    <x-input.input-group>
                                        <x-slot:label>To</x-slot:label>
                                        <x-input type="text" placeholder="0.00" x-mask:dynamic="$money($input)"
                                            x-model="amount_max" />
                                    </x-input.input-group>
                                </div>
                                <div class="flex justify-end gap-2 w-full">
                                    <x-button.outline-button @click.stop="cancelSetAmount()"
                                        class="!border">cancel</x-button.outline-button>
                                    <x-button.outline-button @click="amount_min=null;amount_max=null;"
                                        class="!border">clear</x-button.outline-button>
                                    <x-button.filled-button
                                        @click.stop="applyAmount();show_amount_range_dropdown=false;">apply</x-button.filled-button>
                                </div>

                            </div>
                        </div>
                        {{-- Destination --}}
                        <div class="relative" @click.outside="show_destination_selection = false">
                            <x-button.dropdown-icon-button icon="bank" title="Destination" width="52"
                                @click="show_destination_selection=!show_destination_selection" />
                            <div x-show="show_destination_selection">
                                <livewire:merchant.financial-transaction.components.destination-selection :$merchant
                                    :$selected_provider_codes :$selected_biller_names :destination_event="$event_destination"
                                    :key="$event_destination" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <livewire:dynamic-component :is="$paginated_data_component" :$from_date :$to_date :$merchant :$search_term :$records_per_page
            :$amount_min :$amount_max :$selected_requested_by_ids :$selected_provider_codes :$selected_biller_names
            :key="$paginated_data_component" />
    </div>

    <div x-show="show_transaction_details" id="transaction_detail" class="p-5"></div>
</div>
@script
    <script>
        Alpine.data('cashOutflowIndex', () => ({
            show_export_form: false,
            show_transaction_details: false,
            show_filters_dropdown: false,
            show_requested_by_dropdown: false,
            show_amount_range_dropdown: false,
            show_destination_selection: false,
            set_amount_min: null,
            set_amount_max: null,
            amount_min: null,
            amount_max: null,
            requested_by_event_name: @js($event_requested_by),
            destination_event_name: @js($event_destination),

            init() {
                this.$wire.on('closeCashOutflowExportModal', () => {
                    this.show_export_form = false;
                });

                this.$wire.on('closeTransactionDetails', () => {
                    this.show_transaction_details = false;
                });

                this.$wire.on('showTransactionDetails', () => {
                    this.show_transaction_details = true;
                });

                this.$wire.on('set' + this.requested_by_event_name, () => {
                    this.show_requested_by_dropdown = false;
                });

                this.$wire.on('closeModal' + this.requested_by_event_name, () => {
                    this.show_requested_by_dropdown = false;
                });

                this.$wire.on('close' + this.destination_event_name, () => {
                    this.show_destination_selection = false;
                });

                this.$wire.on('set' + this.destination_event_name, () => {
                    this.show_destination_selection = false;
                });
            },

            cancelSetAmount() {
                this.show_amount_range_dropdown = false;
                this.amount_min = this.set_amount_min;
                this.amount_max = this.set_amount_max;
            },

            applyAmount() {
                this.set_amount_min = this.amount_min;
                this.set_amount_max = this.amount_max;
                this.$wire.applyAmounts(this.amount_min, this.amount_max);
            },

        }));
    </script>
@endscript
