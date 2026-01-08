<div class="w-80 p-6 bg-white rounded-xl shadow-md" x-data="{ open: false }">
    <h2 class="text-rp-neutral-700 font-bold text-xl">Export Data</h2>
    <p class="text-rp-neutral-700">Feel free to set the following filters for the exported data.</p>

    <div class="my-2 flex flex-col gap-2.5 text-rp-neutral-700 text-sm">
        <div class="relative">
            <button @click="open = !open"
                class="w-full px-4 py-2 border border-rp-neutral-500 rounded-lg text-left focus:outline-none focus:ring-2 focus:ring-pink-500 flex items-center justify-between">
                <div class="flex gap-2 items-center">
                    <x-icon.cash width="20" height="20" color="#647887" />
                    Transaction Type
                </div>
                <x-icon.chevron-down width="24" height="24" color="#647887" />
            </button>

            <div x-show="open" @click.outside="open = false"
                class="absolute mt-1 w-full bg-white border rounded-md shadow-md text-rp-neutral-500 z-20">
                @foreach ($this->transaction_types as $type)
                    <div class="w-full flex items-center gap-2 p-3">
                        <input type="checkbox" name="{{ $type }}" value="{{ $type }}" wire:model="selected_types" id="{{ $type }}"
                            class="w-4 h-4 border-rp-neutral-500" />
                        <label for="{{ $type }}">
                            {{ str_replace('_', ' ', ucwords($type)) }}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>

        <x-date-picker.date-range-picker :$from :$to id="MechantCashInExport" />
    </div>

    <div class="flex justify-end mb-8">
        <button wire:click="clear_filters" class="text-rp-red-500 text-sm underline">Clear filters</button>
    </div>

    <div class="flex justify-end gap-2">
        <x-button.outline-button color="red" @click="$dispatch('closeCashInflowExportModal')" class="!border">
            Cancel
        </x-button.outline-button>
        <x-button.filled-button color="red" wire:click.prevent="export_csv" wire:loading.attr="disabled" wire:target="export_csv">
            Export CSV
        </x-button.filled-button>
    </div>
</div>
