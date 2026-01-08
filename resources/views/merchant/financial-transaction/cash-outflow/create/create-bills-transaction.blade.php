<div class="flex flex-col gap-2 mt-3">
    <x-input.input-group>
        <x-slot:label>Biller type:</x-slot:label>
        <div x-data="billerDropdown">
            <!-- Search Box -->
            <x-input type="text" placeholder="Search biller..." x-model="search"
                class="w-full border rounded px-2 py-1 mb-1" @focus="inputFocused=true" @click.away="inputFocused=false" />
            @error('biller_tag')
                <span class="text-xs text-red-500">{{ $message }}</span>
            @enderror
            <template x-if="Object.entries(options).length === 0">
                <span class="text-xs text-red-500">No banks are available for this transaction channel at the
                    moment</span>
            </template>
            <template x-if="Object.entries(options).length > 0">
                <!-- Dropdown -->
                <div class="border rounded max-h-60 overflow-y-auto bg-white" x-show="inputFocused">
                    <template x-for="(options, category) in filteredOptions" :key="category">
                        <div>
                            <div class="bg-gray-100 px-2 py-1 font-semibold text-sm" x-text="category"></div>
                            <template x-for="option in options" :key="option.tag">
                                <div class="px-3 py-1 hover:bg-blue-100 cursor-pointer" @click="select(option)"
                                    x-text="option.name"></div>
                            </template>
                        </div>
                    </template>
                </div>
            </template>
        </div>
    </x-input.input-group>

    @if (!empty($this->biller_field_details))
        <div class="flex flex-row justify-between gap-2">
            @foreach ($this->biller_field_details as $key => $biller_field)
                <x-input.input-group class="flex-1" wire:key="biller_field-{{ $key }}">
                    <x-slot:label for="biller_field-{{ $key }}">{{ $biller_field['Caption'] }}:</x-slot:label>
                    <x-input type="text" maxlength="{{ $biller_field['Width'] }}"
                        wire:model.blur="bill_info.{{ $key }}"
                        oninput="{{ $biller_field['Format'] === 'Numeric' ? 'this.value = this.value.replace(/[^0-9]/gi, \'\')' : '' }}"
                        id="biller_field-{{ $key }}">
                    </x-input>
                    @error('bill_info.' . $key)
                        <p class="text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </x-input.input-group>
            @endforeach
        </div>
    @endif

    <x-input.input-group>
        <x-slot:label>Amount</x-slot:label>
        <x-input type="text" placeholder="0.00" x-mask:dynamic="$money($input)" wire:model.blur="amount" />
        @error('amount')
            <p class="text-xs text-red-500">{{ $message }}</p>
        @enderror
    </x-input.input-group>



    <template x-teleport="#transactionSummary">
        <div class="w-full h-full p-4">
            <x-ui.summary class="w-full h-full">
                <x-slot:body>
                    <x-ui.summary.section title="Payment Details" color="primary">
                        <x-slot:data>
                            <x-ui.summary.label-data>
                                <x-slot:label>Biller</x-slot:label>
                                <x-slot:data>{{ $this->biller_name ?? '-' }}</x-slot:data>
                            </x-ui.summary.label-data>
                            @if (!empty($this->biller_field_details))
                                @foreach ($this->biller_field_details as $key => $biller_field)
                                    <x-ui.summary.label-data wire:key="{{ $key }}">
                                        <x-slot:label>{{ $biller_field['Caption'] }}</x-slot:label>
                                        <x-slot:data>{{ !empty($bill_info[$key]) ? $bill_info[$key] : '-' }}</x-slot:data>
                                    </x-ui.summary.label-data>
                                @endforeach
                            @endif
                            <x-ui.summary.label-data>
                                <x-slot:label>Amount</x-slot:label>
                                <x-slot:data>{{ $this->sanitized_amount ? \Number::currency($this->sanitized_amount, 'PHP') : '-' }}</x-slot:data>
                            </x-ui.summary.label-data>
                        </x-slot:data>
                    </x-ui.summary.section>
                </x-slot:body>
                <x-slot:action>
                    <div class="flex flex-col gap-2 mt-auto">
                        <div>
                            <label for="agree" class="flex flex-row gap-2 items-center">
                                <x-input type="checkbox" id="agree" wire:model="agreed_to_correct_info" />
                                <span>I agree that the above infromation is correct.</span>
                            </label>
                            @error('agreed_to_correct_info')
                                <p class="text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        <x-button.filled-button wire:click="submit" wire:target="submit" wire:loading.attr="disabled">
                            submit
                        </x-button.filled-button>
                        <x-button.outline-button href="{{ $redirect_cancel }}">
                            cancel
                        </x-button.outline-button>
                    </div>
                </x-slot:action>
            </x-ui.summary>
        </div>
    </template>

    <x-loader.black-screen wire:loading.block wire:target="submit" class="z-10" />

</div>
@script
    <script>
        Alpine.data('billerDropdown', () => ({
            search: "",
            selected: null,
            options: @json($this->billers_list),
            inputFocused: false,

            get filteredOptions() {
                if (!this.search) return this.options;

                const query = this.search.toLowerCase();
                let filtered = {};

                for (const [category, items] of Object.entries(this.options)) {
                    let matches = items.filter(option =>
                        option.name.toLowerCase().includes(query) ||
                        option.tag.toLowerCase().includes(query)
                    );

                    if (matches.length) {
                        filtered[category] = matches;
                    }
                }

                return filtered;
            },

            select(option) {
                if (!option.status) {
                    this.$dispatch('notify', {
                        type: "error",
                        title: "Error: Biller Not Active",
                        message: "The selected biller is not active/available at the moment."
                    });
                    return;
                }
                this.inputFocused = false;
                this.search = option.name;
                this.$wire.setBillerTag(option.tag);
            }
        }));
    </script>
@endscript
