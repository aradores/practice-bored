<div class="flex flex-col gap-2 mt-3">
    <x-input.input-group>
        <x-slot:label>Send via:</x-slot:label>
        <div class="flex flex-row gap-3">
            {{-- Instapay --}}
            <button wire:click="$set('send_via', 'instapay')"
                class="border border-rp-neutral-500 bg-white rounded-lg px-2 py-3 flex flex-row justify-between items-center gap-2 flex-1">
                <img src="{{ url('images/instapay.svg') }}" alt="Instapay">
                <div x-show="$wire.send_via === 'instapay'">
                    <x-icon.check />
                </div>
            </button>
            {{-- Pesonet --}}
            <button wire:click="$set('send_via', 'pesonet')"
                class="border border-rp-neutral-500 bg-white rounded-lg px-2 py-3 flex flex-row justify-between items-center gap-2 flex-1">
                <img src="{{ url('images/pesonet.svg') }}" alt="Pesonet">
                <div x-show="$wire.send_via === 'pesonet'">
                    <x-icon.check />
                </div>
            </button>
        </div>
    </x-input.input-group>


    <x-input.input-group>
        <x-slot:label>Select Bank:</x-slot:label>
        <div class="" x-data="bankDropdown">
            <x-input type="text" placeholder="Search bank..." x-model="search"
                class="w-full border rounded px-2 py-1 mb-1" @focus="inputFocused=true"
                @click.away="inputFocused=false" />
            @if (empty($this->instapay_banks))
                <template x-if="$wire.send_via === 'instapay'">
                    <span class="text-xs text-red-500">No banks are available for this transaction channel at the
                        moment</span>
                </template>
            @endif
            @if (empty($this->pesonet_banks))
                <template x-if="$wire.send_via === 'pesonet'">
                    <span class="text-xs text-red-500">No banks are available for this transaction channel at the
                        moment</span>
                </template>
            @endif
            <template x-if="instapay_banks.length > 0">
                <template x-if="$wire.send_via === 'instapay'">
                    <div x-cloak x-show="inputFocused" class="border rounded max-h-60 overflow-y-auto bg-white">
                        <template x-for="(bank, index) in filteredInstapayBanks" :key="'instapay_bank' + index">
                            <div class="px-3 py-1 hover:bg-rp-neutral-100 cursor-pointer" @click="select(bank)"
                                x-text="bank.name"></div>
                        </template>
                    </div>
                </template>
            </template>
            <template x-if="pesonet_banks.length > 0">
                <template x-if="$wire.send_via === 'pesonet'">
                    <div x-cloak x-show="inputFocused" class="border rounded max-h-60 overflow-y-auto bg-white">
                        <template x-for="(bank, index) in filteredPesonetBanks" :key="'pesonet_bank' + index">
                            <div class="px-3 py-1 hover:bg-rp-neutral-100 cursor-pointer" @click="select(bank)"
                                x-text="bank.name"></div>
                        </template>
                    </div>
                </template>
            </template>
        </div>
    </x-input.input-group>

    <div class="flex flex-row gap-2">
        <x-input.input-group class="flex-1">
            <x-slot:label>Account Number:</x-slot:label>
            <x-input type="text" wire:model.blur="account_number"
                oninput="this.value = this.value.replace(/[^0-9]/gi, '')" maxlength="30">
                <x-slot:icon>
                    <x-icon.user />
                </x-slot:icon>
            </x-input>
            @error('account_number')
                <p class="text-xs text-red-500">{{ $message }}</p>
            @enderror
        </x-input.input-group>
        <x-input.input-group class="flex-1">
            <x-slot:label>Account Name:</x-slot:label>
            <x-input type="text" maxlength="50" wire:model.blur="account_name" />
            @error('account_name')
                <p class="text-xs text-red-500">{{ $message }}</p>
            @enderror
        </x-input.input-group>
    </div>

    <div class="flex flex-row justify-between gap-2 mb-9">
        <x-input.input-group class="flex-1">
            <x-slot:label for="amount">Amount:</x-slot:label>
            <x-input type="text" placeholder="0.00" x-mask:dynamic="$money($input)" wire:model.blur="amount">
            </x-input>
            @error('amount')
                <p class="text-xs text-red-500">{{ $message }}</p>
            @enderror
        </x-input.input-group>
    </div>

    <template x-teleport="#transactionSummary">
        <div class="w-full h-full p-4">
            <x-ui.summary class="w-full h-full">
                <x-slot:body>
                    <x-ui.summary.section title="Payment Details" color="primary">
                        <x-slot:data>
                            <x-ui.summary.label-data>
                                <x-slot:label>Transaction type</x-slot:label>
                                <x-slot:data>Cash Out</x-slot:data>
                            </x-ui.summary.label-data>
                            <div
                                class="text-sm flex flex-col-reverse lg:flex-row justify-between gap-2 py-2 [&:not(:last-child)]:border-b [&:not(:last-child)]:border-rp-neutral-100 w-full">
                                <p class="xl:w-2/5 break-words">Send via</p>
                                @if (!empty($send_via))
                                    <div class="text-rp-neutral-700 font-bold w-3/5 break-words flex justify-end"
                                        x-show="$wire.send_via === 'instapay'">
                                        <img src="{{ url('/images/instapay.svg') }}" alt="instapay">
                                    </div>
                                    <div class="text-rp-neutral-700 font-bold w-3/5 break-words flex justify-end"
                                        x-show="$wire.send_via === 'pesonet'">
                                        <img src="{{ url('/images/pesonet.svg') }}" alt="pesonet">
                                    </div>
                                @else
                                    -
                                @endif
                            </div>
                            @if (!empty($selected_bank_code))
                                <x-ui.summary.label-data>
                                    <x-slot:label>Bank Name</x-slot:label>
                                    <x-slot:data>{{ $this->bank_name }}</x-slot:data>
                                </x-ui.summary.label-data>
                            @endif
                            @if (!empty($account_number))
                                <x-ui.summary.label-data>
                                    <x-slot:label>Account Number</x-slot:label>
                                    <x-slot:data>{{ $account_number }}</x-slot:data>
                                </x-ui.summary.label-data>
                            @endif
                            @if (!empty($account_name))
                                <x-ui.summary.label-data>
                                    <x-slot:label>Account Name</x-slot:label>
                                    <x-slot:data>{{ $account_name }}</x-slot:data>
                                </x-ui.summary.label-data>
                            @endif
                            <x-ui.summary.label-data>
                                <x-slot:label>Amount</x-slot:label>
                                <x-slot:data>{{ $this->sanitized_amount ? \Number::currency($this->sanitized_amount, 'PHP') : '-' }}</x-slot:data>
                            </x-ui.summary.label-data>
                            @if ($this->service_fee > 0)
                                <x-ui.summary.label-data>
                                    <x-slot:label>Service Fee</x-slot:label>
                                    <x-slot:data>{{ $this->sanitized_amount ? \Number::currency($this->service_fee, 'PHP') : '-' }}</x-slot:data>
                                </x-ui.summary.label-data>
                            @endif
                            @if (!empty($this->sanitized_amount) and $this->service_fee > 0)
                                <x-ui.summary.label-data>
                                    <x-slot:label>Total</x-slot:label>
                                    <x-slot:data>{{ \Number::currency($this->sanitized_amount + $this->service_fee, 'PHP') }}</x-slot:data>
                                </x-ui.summary.label-data>
                            @endif
                        </x-slot:data>
                    </x-ui.summary.section>
                    <x-card.outflow direction="col" :balance="$this->latest_balance" :outflow="$this->sanitized_amount" />
                </x-slot:body>
                <x-slot:action>
                    <div class="flex flex-col gap-2 mt-auto">
                        <div>
                            <label for="agree" class="flex flex-row gap-2 items-center">
                                <x-input type="checkbox" id="agree" wire:model="agreed_to_correct_info" />
                                <span>I agree that the above infromation is correct.</span>
                            </label>
                            @error('agreed_to_correct_info')
                                <p class="text-sm text-red-600">{{ $message }}</p>
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
        Alpine.data('bankDropdown', () => ({
            search: "",
            inputFocused: false,
            instapay_banks: @json($this->instapay_banks),
            pesonet_banks: @json($this->pesonet_banks),

            init() {
                this.$watch('$wire.send_via', () => {
                    this.search = '';
                });
            },

            get filteredInstapayBanks() {
                if (!this.search) return this.instapay_banks;

                const query = this.search.toLowerCase();

                return this.instapay_banks.filter(bank => bank.name.toLowerCase().includes(query));
            },

            get filteredPesonetBanks() {
                if (!this.search) return this.pesonet_banks;

                const query = this.search.toLowerCase();

                return this.pesonet_banks.filter(bank => bank.name.toLowerCase().includes(query));
            },


            select(option) {
                this.inputFocused = false;
                this.search = option.name;
                this.$wire.selected_bank_code = option.code;
            },
        }));
    </script>
@endscript
