<div class="w-80 p-6 bg-white rounded-xl shadow-md" x-data="cashOutflowExport">
    <h2 class="text-rp-neutral-700 font-bold text-xl">Export Data</h2>
    <p class="text-rp-neutral-700">Feel free to set the following filters for the exported data. NOTE: Only Approved
        Transactions will be exported.</p>

    <div class="my-2 flex flex-col gap-2.5 text-rp-neutral-700 text-sm">
        <div class="relative">
            <x-button.dropdown-icon-button icon="wallet-outline" title="Transaction Type" width="full"
                @click="show_type_selection=!show_type_selection" />

            <div x-show="show_type_selection" @click.outside="show_type_selection = false"
                class="absolute mt-1 w-full bg-white border rounded-md shadow-md text-rp-neutral-500 z-20">
                @foreach ($this->transaction_types as $type)
                    <div class="w-full flex items-center gap-2 p-3">
                        <input type="checkbox" name="{{ $type }}" value="{{ $type }}"
                            id="{{ $type }}" wire:model="selected_types"
                            class="w-4 h-4 border-rp-neutral-500" />
                        <label for="{{ $type }}">
                            {{ str_replace('_', ' ', ucwords($type)) }}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>

        <x-date-picker.date-range-picker :$from :$to id="MechantCashOutExport" />

        <div class="relative" @click.outside="show_requestor_selection = false">
            <x-button.dropdown-icon-button icon="cash" title="Requested by" width="full"
                @click="show_requestor_selection=!show_requestor_selection" />
            <div x-show="show_requestor_selection">
                <livewire:merchant.financial-transaction.components.requestor-selection :$merchant
                    :$selected_requestor_ids event_id="SelectedRequestors" />
            </div>
        </div>


        <div class="relative" @click.outside="show_destination_selection = false">
            <x-button.dropdown-icon-button icon="bank" title="Destination" width="full"
                @click="show_destination_selection=!show_destination_selection" />
            <div x-show="show_destination_selection">
                <livewire:merchant.financial-transaction.components.destination-selection :$merchant
                    :$selected_provider_codes :$selected_biller_names :destination_event="$destination_event_id" :key="$destination_event_id" />
            </div>
        </div>
    </div>

    <div class="flex justify-end mb-4">
        <button wire:click="clear_filters" class="text-rp-red-500 text-sm underline">Clear filters</button>
    </div>

    @if ($errors->any())
        <ul class="flex flex-col gap-2 mb-4 text-red-500 text-xs list-disc list-inside">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <div class="flex justify-end mt-4 gap-2">
        <x-button.outline-button color="red" @click="$dispatch('closeCashOutflowExportModal')" class="!border">
            Cancel
        </x-button.outline-button>
        <x-button.filled-button color="red" wire:click.prevent="export_csv" wire:loading.attr="disabled"
            wire:target="export_csv">
            Export CSV
        </x-button.filled-button>
    </div>
</div>
@script
    <script>
        Alpine.data('cashOutflowExport', () => ({
            show_type_selection: false,
            show_requestor_selection: $wire.entangle('show_requestor_selection'),
            show_destination_selection: $wire.entangle('show_destination_selection'),
            event_destination: @js($destination_event_id),

            init() {
                this.$wire.on('closeModalSelectedRequestors', () => {
                    this.show_requestor_selection = false;
                });
                this.$wire.on('close' + this.event_destination, () => {
                    this.show_destination_selection = false;
                });
            }
        }));
    </script>
@endscript
