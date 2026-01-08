<x-modal.form-modal class="!text-rp-neutral-700 !w-[737px]" title="Confirmation"
    subtitle="You are about to retry sending the failed scheduled salary.">
    <x-table.rounded class="text-sm">
        <x-slot:table_header>
            <x-table.rounded.th>Employee</x-table.rounded.th>
            <x-table.rounded.th>Net Pay</x-table.rounded.th>
            <x-table.rounded.th>Created By</x-table.rounded.th>
            <x-table.rounded.th>Proposed Payout Date</x-table.rounded.th>
        </x-slot:table_header>
        <x-slot:table_data class="break-words mt-5">
            <x-table.rounded.row>
                <x-table.rounded.td class="w-36 max-w-36 min-w-36 bg-rp-neutral-50">
                    {{ $this->recipient_name }}
                </x-table.rounded.td>
                <x-table.rounded.td class="w-36 max-w-36 min-w-36 bg-rp-neutral-50 text-primary-800 font-bold">
                    {{ Number::currency($payroll_disbursement->net_salary, 'PHP') }}
                </x-table.rounded.td>
                <x-table.rounded.td class="w-36 max-w-36 min-w-36 bg-rp-neutral-50">
                    {{ $this->creator_name }}
                </x-table.rounded.td>
                <x-table.rounded.td class="w-52 max-w-52 min-w-52 bg-rp-neutral-50 text-rp-red-600">
                    {{ $payroll_disbursement->payout_at ? \Carbon\Carbon::parse($payroll_disbursement->payout_at)->timezone('Asia/Manila')->format('M d, Y h:i A') : 'Immediately' }}
                </x-table.rounded.td>
            </x-table.rounded.row>
        </x-slot:table_data>
    </x-table.rounded>
    <x-slot:action_buttons>
        <div class="w-full flex justify-end gap-2">
            <x-button.outline-button color="red" @click="$dispatch('closeModal');visible=false"
                class="!p-2.5 !border">Go Back</x-button.outline-button>
            <x-button.filled-button color="red" class="!p-2.5 !border" wire:click="retryFailed">
                Confirm
            </x-button.filled-button>
        </div>
    </x-slot:action_buttons>
</x-modal.form-modal>
