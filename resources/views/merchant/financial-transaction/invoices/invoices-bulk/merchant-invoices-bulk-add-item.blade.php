<x-modal.form-modal class="!w-[900px]" title="{{ $label }} Item/Service">
    <div class="flex flex-col gap-3">
        <x-input.input-group>
            <x-slot:label>Name*</x-slot:label>
            <x-input type="text" name="name" wire:model='form.name' maxlength="255" />
            @error('form.name')
                <p class="text-xs text-red-500">{{ $message }}</p>
            @enderror
        </x-input.input-group>
        <x-input.input-group>
            <x-slot:label>Description</x-slot:label>
            <x-input.textarea row="4" wire:model="form.description" />
            @error('form.description')
                <span class="text-xs text-red-500">{{ $message }}</span>
            @enderror
        </x-input.input-group>
        <div class="flex flex-row gap-2">
            <x-input.input-group class="w-1/2">
                <x-slot:label>Quantity</x-slot:label>
                <x-input type="number" placeholder="0" wire:model="form.quantity" />
                @error('form.quantity')
                    <span class="text-xs text-red-500">{{ $message }}</span>
                @enderror
            </x-input.input-group>

            <x-input.input-group class="w-1/2">
                <x-slot:label>Price</x-slot:label>
                <x-input type="text" placeholder="0.00" x-mask:dynamic="$money($input)" wire:model="form.price" />
                @error('form.price')
                    <span class="text-xs text-red-500">{{ $message }}</span>
                @enderror
            </x-input.input-group>
        </div>
    </div>
    <x-slot:action_buttons>
        <x-button.outline-button wire:click="$dispatch('closeModal')" class="w-1/2" wire:loading.attr='disabled'
            wire:loading.class='cursor-progress'
            color="{{ $is_admin ? 'primary' : 'red' }}">cancel</x-button.outline-button>
        <x-button.filled-button wire:click="save" class="w-1/2"
            color="{{ $is_admin ? 'primary' : 'red' }}">submit</x-button.filled-button>
    </x-slot:actions>
</x-modal.form-modal>
