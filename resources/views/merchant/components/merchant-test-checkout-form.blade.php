<div x-data="{ showCheckoutModal: false }">
    <x-button.filled-button color="primary" class="align-bottom" @click="showCheckoutModal=true">
        Create Checkout
    </x-button.filled-button>

    <template x-teleport="body">
        <x-modal x-model="showCheckoutModal">
            <x-modal.form-modal title="Create Test Checkout">
                <div class="flex flex-col gap-2">
                    <x-input.input-group>
                        <x-slot:label>Order Reference:</x-slot:label>
                        <x-input.input type="number" wire:model="order_reference" />
                        @error('order_reference')
                            <p class="text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </x-input.input-group>
                    <x-input.input-group>
                        <x-slot:label>Amount:</x-slot:label>
                        <x-input.input type="number" wire:model="amount" />
                        @error('amount')
                            <p class="text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </x-input.input-group>
                    <x-input.input-group>
                        <x-slot:label>Redirect URL:</x-slot:label>
                        <x-input.input type="text" wire:model="redirect_url" />
                        @error('redirect_url')
                            <p class="text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </x-input.input-group>
                    <x-input.input-group>
                        <x-slot:label>Customer Name:</x-slot:label>
                        <x-input.input type="text" wire:model="customer_name" />
                        @error('customer_name')
                            <p class="text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </x-input.input-group>
                    <x-input.input-group>
                        <x-slot:label>Customer Email:</x-slot:label>
                        <x-input.input type="email" wire:model="customer_email" />
                        @error('customer_email')
                            <p class="text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </x-input.input-group>
                    <x-input.input-group>
                        <x-slot:label>Customer Phone:</x-slot:label>
                        <x-input.input type="tel" wire:model="customer_phone" />
                        @error('customer_phone')
                            <p class="text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </x-input.input-group>
                    <x-input.input-group>
                        <x-slot:label>Customer IP:</x-slot:label>
                        <x-input.input type="text" wire:model="customer_ip" />
                        @error('customer_ip')
                            <p class="text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </x-input.input-group>
                    <x-input.input-group>
                        <x-slot:label>Description (Optional):</x-slot:label>
                        <x-input.input type="text" wire:model="description" />
                        @error('description')
                            <p class="text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </x-input.input-group>
                </div>
                <x-slot:action_buttons>
                    <x-button.filled-button class="flex-1" color="primary" wire:click="createTestCheckout">
                        Create
                    </x-button.filled-button>
                    <x-button.outline-button class="flex-1" color="primary" @click="showCheckoutModal=false">
                        Cancel
                    </x-button.outline-button>
                </x-slot:action_buttons>
            </x-modal.form-modal>
        </x-modal>
    </template>
</div>
