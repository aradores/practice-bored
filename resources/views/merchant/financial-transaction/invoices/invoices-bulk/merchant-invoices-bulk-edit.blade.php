<x-modal.form-modal title="Edit Row">
    <div>
        <x-input.input-group class="mb-3">
            <x-slot:label>Phone Number*</x-slot:label>
            <x-input type="tel" name="phone_number" wire:model='form.phone_number' />
            @error('form.phone_number')
                <p class="text-xs text-red-500">{{ $message }}</p>
            @enderror
        </x-input.input-group>
        <x-input.input-group class="mb-3">
            <x-slot:label>Message</x-slot:label>
            <x-input.textarea row="3" wire:model="form.message" />
            @error('form.message')
                <span class="text-xs text-red-500">{{ $message }}</span>
            @enderror
        </x-input.input-group>
        <div class="flex flex-row gap-2 mb-3">
            <x-input.input-group class="w-1/2">
                <x-slot:label>Due Date</x-slot:label>
                <x-input type="date" name="due_date" wire:model='form.due_date' />
                @error('form.due_date')
                    <p class="text-xs text-red-500">{{ $message }}</p>
                @enderror
            </x-input.input-group>
            <x-input.input-group class="w-1/2">
                <x-slot:label>Partial Payment</x-slot:label>
                <x-input type="text" name="partial_payment" x-mask:dynamic="$money($input)" wire:model='form.partial_payment' />
                @error('form.partial_payment')
                    <p class="text-xs text-red-500">{{ $message }}</p>
                @enderror
            </x-input.input-group>
        </div>
    </div>
    <x-slot:action_buttons>
        <x-button.outline-button wire:click="$dispatch('closeModal')" class="w-1/2" wire:loading.attr='disabled'
            wire:loading.class='cursor-progress'
            color="{{ $is_admin ? 'primary' : 'red' }}">cancel</x-button.outline-button>
        <x-button.filled-button wire:click="updateRow" class="w-1/2"
            color="{{ $is_admin ? 'primary' : 'red' }}">submit</x-button.filled-button>
    </x-slot:actions>
</x-modal.form-modal>
