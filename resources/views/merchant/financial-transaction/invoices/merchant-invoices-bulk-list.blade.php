<x-main.content class="overflow-y-auto grow" x-data="manageBulkInvoices">
    <x-main.action-header>
        <x-slot:title>Bulk Invoices</x-slot:title>
        <x-slot:actions>
            <div wire:ignore class="flex gap-1">
                @if ($is_admin)
                    <x-button.filled-button color="primary" @click="showUploadInvoicesModal=true">
                        upload invoice
                    </x-button.filled-button>
                @else
                    @can('merchant-invoices', [$merchant, 'create'])
                        <x-button.filled-button @click="showUploadInvoicesModal=true">
                            upload invoice
                        </x-button.filled-button>
                    @endcan
                @endif
            </div>
        </x-slot:actions>
    </x-main.action-header>


    <div class="relative grid grid-cols-3 gap-[15px] mb-8">
        <x-card.filter-card wire:click="changeTab('all')" :isActive="$selectedTab == 0" label="All" :data="$this->all_count"
            color="{{ $is_admin ? 'primary' : 'red' }}" />
        <x-card.filter-card wire:click="changeTab('uploading')" :isActive="$selectedTab == 1" label="Uploading" :data="$this->uploading_count"
            color="{{ $is_admin ? 'primary' : 'red' }}" />
        <x-card.filter-card wire:click="changeTab('pending')" :isActive="$selectedTab == 2" label="Pending" :data="$this->pending_count"
            color="{{ $is_admin ? 'primary' : 'red' }}" />
    </div>

    <div class="space-y-8">
        <div class="overflow-auto">
            <x-table.rounded>
                <x-slot:table_header>
                    <x-table.rounded.th class="w-60 min-w-60">Uploaded Invoice</x-table.rounded.th>
                    <x-table.rounded.th class="w-40 min-w-40">
                        <div class="flex flex-row items-center">
                            <span>Date Uploaded</span>
                            <button wire:click="sortTable('created_at')">
                                <x-icon.sort />
                            </button>
                        </div>
                    </x-table.rounded.th>
                    <x-table.rounded.th class="w-72 min-w-72">Uploaded by</x-table.rounded.th>
                    <x-table.rounded.th class="w-36 min-w-36">Status</x-table.rounded.th>
                    {{-- TO BE DELETED --}}
                    <x-table.rounded.th class="w-72 min-w-72">Actions</x-table.rounded.th>
                </x-slot:table_header>
                <x-slot:table_data>
                    <tr>
                        <td class="pt-8"></td>
                    </tr>
                    @foreach ($this->imported_invoices as $key => $invoice)
                        <x-table.rounded.row class="overflow-hidden" wire:key="imported-invoice-{{ $invoice->id }}">
                            <x-table.rounded.td class="w-60 min-w-60">
                                {{ $invoice->name }}
                            </x-table.rounded.td>
                            <x-table.rounded.td class="w-40 min-w-40">
                                {{ $invoice->created_at->timezone('Asia/Manila')->format('F j, Y') }}
                            </x-table.rounded.td>
                            <x-table.rounded.td class="w-72 min-w-72">
                                {{ $invoice->user->name }}
                            </x-table.rounded.td>
                            <x-table.rounded.td class="w-36 min-w-36">
                                <x-status color="{{ $invoice->status_color }}" class="w-full">
                                    {{ $invoice->status_name }}
                                </x-status>
                            </x-table.rounded.td>
                            <x-table.rounded.td class="w-72 min-w-72">
                                <div class="flex gap-2">
                                    @if (!in_array($invoice->status_name, ['Uploading', 'Disbursing', 'Failed']))
                                        <x-button.outline-button color="{{ $is_admin ? 'primary' : 'red' }}"
                                            class="w-32" :href="$invoice->page_url">
                                            View
                                        </x-button.outline-button>
                                    @endif

                                    @if (!in_array($invoice->status_name, ['Uploading', 'Disbursing', 'Disbursed']))
                                        <x-button.filled-button color="{{ $is_admin ? 'primary' : 'red' }}"
                                            class="w-32"
                                            @click="selectedBulkInvoiceId={{ $invoice->id }};showDeleteModal=true">
                                            Delete
                                        </x-button.filled-button>
                                    @endif
                                </div>
                            </x-table.rounded.td>
                        </x-table.rounded.row>
                    @endforeach
                </x-slot:table_data>
            </x-table.rounded>
        </div>

        {{-- Pagination --}}
        <div class="flex items-center justify-center w-full gap-8">
            {{ $this->imported_invoices->links('pagination.custom-pagination') }}
        </div>
    </div>

    <div x-show="showUploadInvoicesModal" x-cloak>
        <livewire:merchant.financial-transaction.invoices.merchant-invoices-bulk-upload :merchant="$merchant"
            :is_admin="$is_admin" />
    </div>

    <template x-teleport="body">
        <x-modal x-model="showDeleteModal">
            <x-modal.confirmation-modal title="Confirm Bulk Invoice Deletion"
                message="Deleting this bulk invoice will remove all related invoice records. This action cannot be undone. Do you want to continue?">
                <x-slot:action_buttons>
                    <x-button.outline-button color="{{ $is_admin ? 'primary' : 'red' }}" class="w-1/2"
                        @click="showDeleteModal=false">Cancel</x-button.outline-button>
                    <x-button.filled-button color="{{ $is_admin ? 'primary' : 'red' }}" @click="deleteBulkInvoice"
                        class="w-1/2">Proceed</x-button.filled-button>
                </x-slot:action_buttons>
            </x-modal.confirmation-modal>
        </x-modal>
    </template>
</x-main.content>

@script
    <script>
        Alpine.data('manageBulkInvoices', () => ({
            showUploadInvoicesModal: false,
            showDeleteModal: false,
            selectedBulkInvoiceId: null,

            init() {
                this.$wire.on("closeUploadInvoicesModal", () => {
                    this.showUploadInvoicesModal = false;
                });

                this.$wire.on("closeDeleteModal", () => {
                    this.showDeleteModal = false;
                });
            },

            deleteBulkInvoice() {
                @this.deleteBulkInvoice(this.selectedBulkInvoiceId);
            }
        }));
    </script>
@endscript
