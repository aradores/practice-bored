<x-modal.form-modal class="!text-rp-neutral-700 !w-[737px]" title="Delete all records of {{ $type }} payroll?"
    subtitle="Are you sure you want to delete all {{ $this->count > 1 ? $this->count : '' }} records of {{ $type }} payroll? This will permanently erase them from your account forever.">

    <p class="mt-3 text-rp-neutral-500 text-sm"><span class="text-red-500">*</span> Reason for cancellation
        {{ $type }}</p>
    <x-input.textarea wire:model='reason' class="w-full" x-ref='reason' maxlength="1000" rows="6"
        placeholder="e.g., 'Incorrect pay period dates', 'Need to update employee hours', etc." />
    <div class="flex justify-between">
        <div>
            @error('reason')
                <p class="text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>
        <p class="text-right text-[11px]"><span x-html="$wire.reason.length"></span>/<span
                x-html="$refs.reason.maxLength"></span></p>
    </div>

    <x-slot:action_buttons>
        <div class="w-full flex justify-end gap-2">
            <x-button.outline-button color="red" @click="$dispatch('closeModal');visible=false"
                class="!p-2.5 !border">Go Back</x-button.outline-button>
            <x-button.filled-button color="red" class="!p-2.5 !border" wire:click="deleteRecords">
                Confirm
            </x-button.filled-button>
        </div>
    </x-slot:action_buttons>
</x-modal.form-modal>
