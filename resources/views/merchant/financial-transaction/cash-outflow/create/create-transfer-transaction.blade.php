<div class="flex flex-col gap-2">
    <div class="flex flex-row gap-3 mt-3">
        <x-input.input-group class="flex-1">
            <x-slot:label>Phone Number:</x-slot:label>
            <div>
                <div class="flex flex-row gap-1">
                    <x-dropdown.select wire:model.change="phone_iso">
                        <x-dropdown.select.option value="" selected>Select</x-dropdown.select.option>
                        @foreach ($phone_iso_options as $phone_iso)
                            <x-dropdown.select.option
                                value="{{ $phone_iso }}">+({{ $phone_iso }})</x-dropdown.select.option>
                        @endforeach
                    </x-dropdown.select>
                    <x-input id="phone_number" type="tel" placeholder="9123456789" class="flex-1"
                        wire:model.blur="phone_number" maxlength="10"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                        x-bind:disabled="$wire.phone_iso === ''">
                        <x-slot:icon>
                            <x-icon.phone />
                        </x-slot:icon>
                    </x-input>
                </div>
                @error('phone_iso')
                    <p class="text-sm text-red-500">{{ $message }}</p>
                @enderror
                @error('phone_number')
                    <p class="text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
        </x-input.input-group>
        <x-input.input-group class="flex-1">
            <x-slot:label>Amount:</x-slot:label>
            <x-input type="text" placeholder="0.00" x-mask:dynamic="$money($input)" wire:model.blur="amount" />
            @error('amount')
                <p class="text-sm text-red-500">{{ $message }}</p>
            @enderror
        </x-input.input-group>
    </div>

    <x-input.input-group x-data="{ messageTextLength: 0 }">
        <x-slot:label>Message (optional)</x-slot:label>
        <x-input.textarea wire:model.blur="message" x-ref="message"
            @input="messageTextLength = $refs.message.value.length" class="w-full rounded-md" maxlength="255"
            rows="6" />
        @error('message')
            <p class="text-sm text-red-500">{{ $message }}</p>
        @enderror
        <span class="text-xs text-right">
            <span x-text="messageTextLength"></span>/255
        </span>

    </x-input.input-group>  

    <template x-teleport="#transactionSummary">
        <div class="w-full h-full p-4">
            <x-ui.summary class="w-full h-full">
                <x-slot:body>
                    <x-ui.summary.section title="Payment Details" color="primary">
                        <x-slot:data>
                            <x-ui.summary.label-data>
                                <x-slot:label>Recipient</x-slot:label>
                                <x-slot:data>{{ $this->recipient_name ?? '-' }}</x-slot:data>
                            </x-ui.summary.label-data>
                            <x-ui.summary.label-data>
                                <x-slot:label>Phone Number</x-slot:label>
                                <x-slot:data>
                                    @if (!empty($this->recipient_name))
                                        {{ '(+' . $phone_iso . ') ' . $phone_number }}
                                    @else
                                        -
                                    @endif
                                </x-slot:data>
                            </x-ui.summary.label-data>
                            <x-ui.summary.label-data>
                                <x-slot:label>Transaction type</x-slot:label>
                                <x-slot:data>Money Transfer</x-slot:data>
                            </x-ui.summary.label-data>
                            <x-ui.summary.label-data>
                                <x-slot:label>Amount</x-slot:label>
                                <x-slot:data>{{ $this->sanitized_amount ? Number::currency($this->sanitized_amount, 'PHP') : '-' }}</x-slot:data>
                            </x-ui.summary.label-data>
                        </x-slot:data>
                    </x-ui.summary.section>
                    <x-ui.summary.section title="Message" color="primary">
                        <x-slot:data class="text-sm">
                            <p>{{ !empty($message) ? $message : '-' }}</p>
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
                                <p class="text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        <x-button.filled-button wire:click="submit" wire:target="submit" wire:loading.attr="disabled">
                            submit
                        </x-button.filled-button>
                        <x-button.outline-button class="!border" href="{{ $redirect_cancel }}">
                            cancel
                        </x-button.outline-button>
                    </div>
                </x-slot:action>
            </x-ui.summary>
        </div>
    </template>

     <x-loader.black-screen wire:loading.block wire:target="submit" class="z-10" />
</div>