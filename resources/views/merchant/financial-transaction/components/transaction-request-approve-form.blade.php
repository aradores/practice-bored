<x-modal.form-modal class="!text-rp-neutral-700 !w-[737px]" title="Confirmation"
    subtitle="You are about to approve the following {{ strtolower($request->type->name) }}.">
    <x-table.rounded class="text-sm">
        <x-slot:table_header>
            <x-table.rounded.th>Recipient</x-table.rounded.th>
            <x-table.rounded.th>Amount</x-table.rounded.th>
            <x-table.rounded.th>Created By</x-table.rounded.th>
        </x-slot:table_header>
        <x-slot:table_data class="break-words mt-5">
            <x-table.rounded.row>
                <x-table.rounded.td class="w-52 max-w-52 min-w-52 bg-rp-neutral-50" wire:ignore>
                    <p>{{ $recipient }}</p>
                </x-table.rounded.td>
                <x-table.rounded.td class="w-52 max-w-52 min-w-52 bg-rp-neutral-50 text-primary-800 font-bold"
                    wire:ignore>
                    {{ Number::currency($total_amount, $request->currency) }}
                </x-table.rounded.td>
                <x-table.rounded.td class="w-52 max-w-52 min-w-52 bg-rp-neutral-50" wire:ignore>
                    {{ $creator_name }}
                </x-table.rounded.td>
            </x-table.rounded.row>
        </x-slot:table_data>
    </x-table.rounded>
    <x-slot:action_buttons>
        <div class="w-full flex justify-end gap-2">
            <x-button.outline-button color="red" @click="$dispatch('closeModal');visible=false"
                class="!p-2.5 !border">Cancel</x-button.outline-button>
            <x-button.filled-button color="red" class="!p-2.5 !border" wire:click="approveRequest">
                Approve {{ $request->type->name }}
            </x-button.filled-button>
        </div>
    </x-slot:action_buttons>
</x-modal.form-modal>
