<div class="flex h-full" x-data="manageImportedInvoiceRows">
    <x-main.content class="overflow-y-auto grow !px-[18.5px] !py-[30px]">
        <x-main.action-header>
            <x-slot:title>Bulk Invoices</x-slot:title>
            <x-slot:actions>
                <div class="flex gap-1 items-center">
                    @if ($submittable)
                        <x-button.filled-button color="{{ $is_admin ? 'primary' : 'red' }}"
                            @click="$wire.showDisburseInvoicesModal=true" class="w-28">
                            submit
                        </x-button.filled-button>
                    @endif
                </div>
            </x-slot:actions>
        </x-main.action-header>

        <div class="relative grid grid-cols-3 gap-[15px] mb-8">
            <x-card.filter-card wire:click="changeTab('all')" :isActive="$selected_tab === 'all'" label="All" :data="$this->all_rows_count"
                color="{{ $is_admin ? 'primary' : 'red' }}" />
            <x-card.filter-card wire:click="changeTab('no_errors')" :isActive="$selected_tab === 'no_errors'" label="No errors"
                :data="$this->no_error_rows_count" color="{{ $is_admin ? 'primary' : 'red' }}" />
            <x-card.filter-card wire:click="changeTab('has_errors')" :isActive="$selected_tab === 'has_errors'" label="Has errors"
                :data="$this->has_error_rows_count" color="{{ $is_admin ? 'primary' : 'red' }}" />
        </div>

        <div class="space-y-8">
            <div class="overflow-auto">
                <x-table.rounded>
                    <x-slot:table_header>
                        <x-table.rounded.th>Phone Number</x-table.rounded.th>
                        <x-table.rounded.th>
                            <div class="flex flex-row items-center">
                                <span>Due Date</span>
                                <button wire:click="sortTable('due_date')">
                                    <x-icon.sort />
                                </button>
                            </div>
                        </x-table.rounded.th>
                        <x-table.rounded.th>
                            <div class="flex flex-row items-center">
                                <span>Total Payment</span>
                                <button wire:click="sortTable('total')">
                                    <x-icon.sort />
                                </button>
                            </div>
                        </x-table.rounded.th>
                        <x-table.rounded.th>Partial Payment</x-table.rounded.th>
                        <x-table.rounded.th class="w-72 max-w-72">Errors</x-table.rounded.th>
                    </x-slot:table_header>
                    <x-slot:table_data>
                        <tr>
                            <td class="pt-8"></td>
                        </tr>
                        @foreach ($this->bulk_invoice_rows as $key => $invoice)
                            <x-table.rounded.row class="overflow-hidden hover:bg-rp-neutral-50 cursor-pointer"
                                wire:key="imported-invoice-{{ $invoice->id }}"
                                wire:click="showInvoiceDetails({{ $invoice->id }})">
                                <x-table.rounded.td>
                                    {{ $invoice->phone_number ?? '-' }}
                                </x-table.rounded.td>
                                <x-table.rounded.td>
                                    {{ $invoice->due_date ? \Carbon\Carbon::parse($invoice->due_date)->format('Y-m-d') : '-' }}
                                </x-table.rounded.td>
                                <x-table.rounded.td>
                                    {{ $invoice->total ? \Number::currency($invoice->total, 'PHP') : '-' }}
                                </x-table.rounded.td>
                                <x-table.rounded.td>
                                    {{ $invoice->partial_payment ? \Number::currency($invoice->partial_payment, 'PHP') : '-' }}
                                </x-table.rounded.td>
                                <x-table.rounded.td class="w-72 max-w-72">
                                    <ul class="list-disc">
                                        @forelse ($invoice->errors as $key => $errors)
                                            @foreach ($errors as $error)
                                                <li class="text-red-500">{{ $error }}</li>
                                            @endforeach
                                        @empty
                                            <li class="text-rp-green-600">No errors</li>
                                        @endforelse
                                    </ul>
                                </x-table.rounded.td>
                            </x-table.rounded.row>
                        @endforeach
                    </x-slot:table_data>
                </x-table.rounded>
            </div>

            {{-- Pagination --}}
            <div class="flex items-center justify-center w-full gap-8">
                {{ $this->bulk_invoice_rows->links('pagination.custom-pagination') }}
            </div>
        </div>
    </x-main.content>

    @if (!$selected_invoice_row)
        <x-layout.summary headerTitle="Invoice Details">
            <x-slot:action-header>
                <x-main.action-header>
                    <x-slot:title>Invoice Details</x-slot:title>
                </x-main.action-header>
            </x-slot:action-header>
            <x-slot:body>
                <div class="text-center h-96">Select a row to view its details</div>
            </x-slot:body>
        </x-layout.summary>
    @else
        <x-layout.summary headerTitle="Invoice Details">
            <x-slot:action-header>
                <x-main.action-header>
                    <x-slot:title>Invoice Details</x-slot:title>
                </x-main.action-header>
            </x-slot:action-header>
            <x-slot:body>
                <x-layout.summary.section color="{{ $is_admin ? 'primary' : 'red' }}" title="Invoice Details">
                    <x-slot:titleHeaders>
                        @if ($editable)
                            <button @click="$wire.set('showEditImportedRowModal', true)">
                                <x-icon.edit width="28" height="28" />
                            </button>
                        @endif
                    </x-slot:titleHeaders>
                    <x-slot:data>
                        <x-layout.summary.label-data>
                            <x-slot:label>
                                Send to
                            </x-slot:label>
                            <x-slot:data>
                                {{ $this->selected_invoice_row_name }}
                            </x-slot:data>
                        </x-layout.summary.label-data>
                        <x-layout.summary.label-data>
                            <x-slot:label>
                                Phone number
                            </x-slot:label>
                            <x-slot:data>
                                {{ $selected_invoice_row->phone_number ?? '-' }}
                            </x-slot:data>
                        </x-layout.summary.label-data>
                        <x-layout.summary.label-data>
                            <x-slot:label>
                                Due Date
                            </x-slot:label>
                            <x-slot:data>
                                {{ $selected_invoice_row->due_date ? $selected_invoice_row->due_date->format('Y-m-d') : '-' }}
                            </x-slot:data>
                        </x-layout.summary.label-data>
                    </x-slot:data>
                </x-layout.summary.section>
                <x-layout.summary.section color="{{ $is_admin ? 'primary' : 'red' }}" title="Items & Services">
                    <x-slot:titleHeaders>
                        @if ($editable)
                            <button @click="$wire.set('showAddItemToImportedRowModal', true)">
                                <x-icon.add width="26" height="26" />
                            </button>
                        @endif
                    </x-slot:titleHeaders>
                    <x-slot:data>
                        @foreach ($selected_invoice_row->items as $key => $item)
                            <x-layout.summary.label-data>
                                <x-slot:label class="flex gap-1 items-center">
                                    <span>{{ !empty($item['name']) ? $item['name'] : '-' }}</span>
                                    <span
                                        class="text-xs">{{ $item['quantity'] > 1 ? '(x' . $item['quantity'] . ')' : '' }}</span>
                                </x-slot:label>
                                <x-slot:data class="flex justify-end gap-1 items-center">
                                    <span>
                                        {{ is_numeric($item['price']) ? \Number::currency($item['price'], 'PHP') : '-' }}
                                    </span>
                                    @if ($editable)
                                        <button
                                            @click="$wire.set('selected_key', {{ $key }}); $wire.set('showAddItemToImportedRowModal', true)">
                                            <x-icon.edit width="26" height="26" />
                                        </button>
                                        <button
                                            @click="$wire.set('selected_key', {{ $key }}); $wire.set('showDeleteItemConfirmModal', true)">
                                            <x-icon.trash width="26" height="26" />
                                        </button>
                                    @endif
                                </x-slot:data>
                            </x-layout.summary.label-data>
                        @endforeach
                        <x-layout.summary.label-data>
                            <x-slot:label>
                                Total
                            </x-slot:label>
                            <x-slot:data class="{{ $is_admin ? '!text-primary-600' : '!text-rp-red-500' }}">
                                {{ $selected_invoice_row->items_price ? \Number::currency($selected_invoice_row->items_price, 'PHP') : '-' }}
                            </x-slot:data>
                        </x-layout.summary.label-data>
                    </x-slot:data>
                </x-layout.summary.section>
                <x-layout.summary.section color="{{ $is_admin ? 'primary' : 'red' }}" title="Inclusions">
                    <x-slot:titleHeaders>
                        @if ($editable)
                            <button @click="$wire.set('showAddInclusionToImportedRowModal', true)">
                                <x-icon.add width="26" height="26" />
                            </button>
                        @endif
                    </x-slot:titleHeaders>
                    <x-slot:data>
                        @foreach ($selected_invoice_row->inclusions as $key => $inclusion)
                            <x-layout.summary.label-data>
                                <x-slot:label>
                                    {{ $inclusion['name'] ?? '-' }}
                                </x-slot:label>
                                <x-slot:data class="flex justify-end gap-1 items-center">
                                    <span>
                                        {{ is_numeric($inclusion['amount']) ? ($inclusion['is_discount'] ? '-' : '') . \Number::currency($inclusion['amount'], 'PHP') : '-' }}
                                    </span>
                                    @if ($editable)
                                        <button
                                            @click="$wire.set('selected_key', {{ $key }}); $wire.set('showAddInclusionToImportedRowModal', true)">
                                            <x-icon.edit width="26" height="26" />
                                        </button>
                                        <button
                                            @click="$wire.set('selected_key', {{ $key }}); $wire.set('showDeleteInclusionConfirmModal', true)">
                                            <x-icon.trash width="26" height="26" />
                                        </button>
                                    @endif
                                </x-slot:data>
                            </x-layout.summary.label-data>
                        @endforeach
                        <x-layout.summary.label-data>
                            <x-slot:label>
                                Total
                            </x-slot:label>
                            <x-slot:data class="{{ $is_admin ? '!text-primary-600' : '!text-rp-red-500' }}">
                                {{ $selected_invoice_row->inclusions_amount ? \Number::currency($selected_invoice_row->inclusions_amount, 'PHP') : '-' }}
                            </x-slot:data>
                        </x-layout.summary.label-data>
                    </x-slot:data>
                </x-layout.summary.section>
                <x-layout.summary.section color="{{ $is_admin ? 'primary' : 'red' }}" title="Summary">
                    <x-slot:data>
                        <x-layout.summary.label-data>
                            <x-slot:label>
                                Items & Services
                            </x-slot:label>
                            <x-slot:data>
                                {{ \Number::currency($selected_invoice_row->items_price, 'PHP') }}
                            </x-slot:data>
                        </x-layout.summary.label-data>
                        @if (!empty($selected_invoice_row->inclusions))
                            <x-layout.summary.label-data>
                                <x-slot:label>
                                    Inclusions
                                </x-slot:label>
                                <x-slot:data>
                                    {{ \Number::currency($selected_invoice_row->inclusions_amount, 'PHP') }}
                                </x-slot:data>
                            </x-layout.summary.label-data>
                        @endif
                        <x-layout.summary.label-data>
                            <x-slot:label>
                                Total
                            </x-slot:label>
                            <x-slot:data class="{{ $is_admin ? '!text-primary-600' : '!text-rp-red-500' }}">
                                {{ \Number::currency($selected_invoice_row->total, 'PHP') }}
                            </x-slot:data>
                        </x-layout.summary.label-data>
                        @if (is_numeric($selected_invoice_row->partial_payment) && $selected_invoice_row->partial_payment > 0)
                            <x-layout.summary.label-data>
                                <x-slot:label>
                                    Partial Payment
                                </x-slot:label>
                                <x-slot:data>
                                    {{ \Number::currency($selected_invoice_row->partial_payment, 'PHP') }}
                                </x-slot:data>
                            </x-layout.summary.label-data>
                        @endif
                    </x-slot:data>
                </x-layout.summary.section>
            </x-slot:body>
            <x-slot:footer>
                <div class="flex justify-end">
                    @if ($editable)
                        <x-button.outline-button color="{{ $is_admin ? 'primary' : 'red' }}" class="w-28"
                            @click="$wire.set('showDeleteModal', true)">
                            Delete
                        </x-button.outline-button>
                    @endif
                </div>
            </x-slot:footer>
        </x-layout.summary>
    @endif

    @if ($submittable)
        <x-modal x-model="$wire.showDisburseInvoicesModal">
            <x-modal.confirmation-modal class="!max-w-md" title="Disburse bulk invoice?"
                message="This action will send the invoices to the respective user accounts. This cannot be undone.">
                <x-slot:action_buttons>
                    <x-button.outline-button color="{{ $is_admin ? 'primary' : 'red' }}" class="w-1/2"
                        @click="$wire.showDisburseInvoicesModal=false">Cancel</x-button.outline-button>
                    <x-button.filled-button color="{{ $is_admin ? 'primary' : 'red' }}" class="w-1/2"
                        wire:click='disburseBulkInvoice'>Proceed</x-button.filled-button>
                </x-slot:action_buttons>
            </x-modal.confirmation-modal>
        </x-modal>
    @endif

    @if ($selected_invoice_row && $editable)
        @if ($showEditImportedRowModal)
            <x-modal x-model="$wire.showEditImportedRowModal">
                <livewire:merchant.financial-transaction.invoices.invoices-bulk.merchant-invoices-bulk-edit
                    :imported_invoice="$imported_invoice" :imported_invoice_row_id="$selected_invoice_row?->id" :is_admin="$is_admin" />
            </x-modal>
        @endif

        @if ($showAddItemToImportedRowModal)
            <x-modal x-model="$wire.showAddItemToImportedRowModal">
                <livewire:merchant.financial-transaction.invoices.invoices-bulk.merchant-invoices-bulk-add-item
                    :item_key="$selected_key" :imported_invoice="$imported_invoice" :imported_invoice_row_id="$selected_invoice_row?->id" :is_admin="$is_admin" />
            </x-modal>
        @endif

        @if ($showAddInclusionToImportedRowModal)
            <x-modal x-model="$wire.showAddInclusionToImportedRowModal">
                <livewire:merchant.financial-transaction.invoices.invoices-bulk.merchant-invoices-bulk-add-inclusion
                    :inclusion_key="$selected_key" :imported_invoice="$imported_invoice" :imported_invoice_row_id="$selected_invoice_row?->id" :is_admin="$is_admin" />
            </x-modal>
        @endif

        @if ($showDeleteModal)
            <x-modal x-model="$wire.showDeleteModal">
                <x-modal.confirmation-modal class="!max-w-[450px]" title="Remove Invoice from Bulk Submission"
                    message="Removing this invoice will exclude it from the bulk submission. This action is irreversible. Do you want to proceed?">
                    <x-slot:action_buttons>
                        <x-button.outline-button color="{{ $is_admin ? 'primary' : 'red' }}" class="w-1/2"
                            @click="$wire.set('showDeleteModal', false)">Cancel</x-button.outline-button>
                        <x-button.filled-button color="{{ $is_admin ? 'primary' : 'red' }}" @click="$wire.deleteInvoiceRow"
                            class="w-1/2">Proceed</x-button.filled-button>
                    </x-slot:action_buttons>
                </x-modal.confirmation-modal>
            </x-modal>
        @endif

        @if ($showDeleteItemConfirmModal)
            <x-modal x-model="$wire.showDeleteItemConfirmModal">
                <x-modal.confirmation-modal class="!max-w-[450px]" title="Remove Item/Service from Invoice"
                    message="This action will remove the item/service from this invoice. Do you want to proceed?">
                    <x-slot:action_buttons>
                        <x-button.outline-button color="{{ $is_admin ? 'primary' : 'red' }}" class="w-1/2"
                            @click="$wire.set('showDeleteItemConfirmModal', false)">Cancel</x-button.outline-button>
                        <x-button.filled-button color="{{ $is_admin ? 'primary' : 'red' }}" @click="$wire.deleteItemFromInvoiceRow"
                            class="w-1/2">Proceed</x-button.filled-button>
                    </x-slot:action_buttons>
                </x-modal.confirmation-modal>
            </x-modal>
        @endif

        @if ($showDeleteInclusionConfirmModal)
            <x-modal x-model="$wire.showDeleteInclusionConfirmModal">
                <x-modal.confirmation-modal class="!max-w-[450px]" title="Remove Inclusion from Invoice"
                    message="This action will remove the inclusion from this invoice. Do you want to proceed?">
                    <x-slot:action_buttons>
                        <x-button.outline-button color="{{ $is_admin ? 'primary' : 'red' }}" class="w-1/2"
                            @click="$wire.set('showDeleteInclusionConfirmModal', false)">Cancel</x-button.outline-button>
                        <x-button.filled-button color="{{ $is_admin ? 'primary' : 'red' }}" @click="$wire.deleteInclusionFromInvoiceRow"
                            class="w-1/2">Proceed</x-button.filled-button>
                    </x-slot:action_buttons>
                </x-modal.confirmation-modal>
            </x-modal>
        @endif
    @endif

</div>