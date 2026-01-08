<div x-data="pendingList" class="w-full">
    @include('merchant.financial-transaction.cash-outflow.cash-outflow-category-filters')

    @include('merchant.financial-transaction.cash-outflow.cash-outflow-pagination-config')

    <div x-cloak x-show="has_selected_all"
        class="w-full flex flex-row gap-1 items-center bg-primary-50 px-11 py-2 rounded-lg my-3">
        {{-- <button><x-icon.close-no-border width="20" height="19" /></button> --}}
        <span>All <strong x-text="`${selected_transaction_requests.length} transactions`"></strong> on this page have
            been selected.
            <button @click="selectAllPendingTransactions">
                <strong class="underline text-primary-700">
                    Select all {{ $this->all_transactions['count'] }} transactions in Pending
                </strong>
            </button>
        </span>
    </div>

    {{-- Table --}}
    <div id="table_wrapper" class="overflow-auto max-w-full w-full">
        <x-table.standard class="overflow-auto max-w-full w-full">
            <x-slot:table_header>
                <x-table.standard.th class="max-w-20 text-center">
                    <x-input type="checkbox" x-model="has_selected_all"
                        @change="handleSelectAllOnChange($event.target.checked)" />
                </x-table.standard.th>
                <x-table.standard.th class="max-w-52">
                    Transaction Type
                </x-table.standard.th>
                <x-table.standard.th class="max-w-52">
                    Destination
                </x-table.standard.th>
                <x-table.standard.th class="max-w-52">
                    Recipient
                </x-table.standard.th>
                <x-table.standard.th class="max-w-40">
                    <div class="flex flex-row items-center gap-2">
                        <div>Amount</div>
                        @php
                            $amount_sort_direction = '';

                            if ($sort_by === 'total_amount') {
                                $amount_sort_direction = $sort_direction === 'desc' ? 'down' : 'up';
                            } else {
                                $amount_sort_direction = 'both';
                            }

                        @endphp
                        <button wire:click="changeSorting('total_amount')"><x-icon.sort :direction="$amount_sort_direction" /></button>
                    </div>
                </x-table.standard.th>
                <x-table.standard.th class="max-w-52">
                    <div class="flex flex-row items-center gap-2">
                        <div>Date Created</div>
                        @php
                            $date_created_sort_direction = '';

                            if ($sort_by === 'created_at') {
                                $date_created_sort_direction = $sort_direction === 'desc' ? 'down' : 'up';
                            } else {
                                $date_created_sort_direction = 'both';
                            }

                        @endphp
                        <button wire:click="changeSorting('created_at')"><x-icon.sort :direction="$date_created_sort_direction" /></button>
                    </div>
                </x-table.standard.th>
                <x-table.standard.th class="max-w-52">
                    <div class="flex flex-row items-center gap-2">
                        <div>Created By</div>
                        @php
                            $created_by_sort_direction = '';

                            if ($sort_by === 'creator_name') {
                                $created_by_sort_direction = $sort_direction === 'desc' ? 'down' : 'up';
                            } else {
                                $created_by_sort_direction = 'both';
                            }

                        @endphp
                        <button wire:click="changeSorting('creator_name')"><x-icon.sort :direction="$created_by_sort_direction" /></button>
                    </div>
                </x-table.standard.th>
                @empty($view_transaction)
                    <x-table.standard.th class="max-w-40">
                        Actions
                    </x-table.standard.th>
                @endempty
            </x-slot:table_header>
            <x-slot:table_data>
                @foreach ($this->transactions as $transaction)
                    <x-table.standard.row class="text-neutral-600" wire:key="transaction-{{ $transaction->id }}">
                        <x-table.standard.td class="max-w-20 text-center">
                            <x-input type="checkbox" x-model.number="selected_transaction_requests"
                                value="{{ $transaction->id }}" />
                        </x-table.standard.td>
                        <x-table.standard.td class="max-w-52">
                            {{ $transaction->type->name }}
                        </x-table.standard.td>
                        <x-table.standard.td class="max-w-52">
                            {{ $transaction->destination_name }}
                        </x-table.standard.td>
                        <x-table.standard.td class="max-w-52">
                            {{ $transaction->recipient_name }}
                        </x-table.standard.td>
                        <x-table.standard.td class="max-w-40">
                            {{ Number::currency($transaction->total_amount, $transaction->currency) }}
                        </x-table.standard.td>
                        <x-table.standard.td class="max-w-52">
                            {{ \Carbon\Carbon::parse($transaction->created_at)->timezone('Asia/Manila')->format('F j, Y') }}
                        </x-table.standard.td>
                        <x-table.standard.td class="max-w-52">
                            {{ $transaction->creator_name }}
                        </x-table.standard.td>
                        @empty($view_transaction)
                            <x-table.standard.td class="max-w-40">
                                <button wire:click="showTransactionRequestDetails('{{ $transaction->id }}')"
                                    class="p-2 rounded-full border border-rp-red-600 hover:bg-rp-red-50">
                                    <x-icon.eye fill="#F70068" width="20" height="20" />
                                </button>
                                <button class="p-2 rounded-full border border-rp-red-600 hover:bg-rp-red-50"
                                    wire:click="showTransactionRequestToReject('{{ $transaction->id }}')">
                                    <x-icon.close-no-border color="#F70068" width="20" height="20" />
                                </button>
                                <button class="p-2 rounded-full border border-transparent bg-rp-red-500"
                                    wire:click="showTransactionRequestToApprove('{{ $transaction->id }}')">
                                    <x-icon.check-no-border color="#FCFDFD" width="20" height="20" />
                                </button>
                            </x-table.standard.td>
                        @endempty
                        @if (isset($view_transaction) && $transaction->id == $view_transaction->id)
                            <x-table.standard.td class="max-w-20">
                                <x-icon.chevron-right />
                            </x-table.standard.td>
                        @else
                            <x-table.standard.td class="max-w-20">
                            </x-table.standard.td>
                        @endif
                    </x-table.standard.row>
                @endforeach
            </x-slot:table_data>
        </x-table.standard>
    </div>

    <div class="flex items-center justify-center w-full gap-8">
        {{ $this->transactions->links('pagination.standard-pagination') }}
    </div>

    @if (!empty($view_transaction))
        <template x-teleport="#transaction_detail">
            <livewire:merchant.financial-transaction.cash-outflow.transaction-request-details :transaction_request="$view_transaction"
                wire:key="pending-txn-{{ $view_transaction->id }}" />
        </template>
    @endif

    @if (!empty($transaction_request_to_reject))
        <x-modal x-model="$wire.show_transaction_request_to_reject_modal">
            <livewire:merchant.financial-transaction.components.transaction-request-reject-form :request="$transaction_request_to_reject"
                wire:key="reject-form-{{ $transaction_request_to_reject?->id }}" />
        </x-modal>
    @endif

    @if (!empty($transaction_request_to_approve))
        <x-modal x-model="$wire.show_transaction_request_to_approve_modal">
            <livewire:merchant.financial-transaction.components.transaction-request-approve-form :request="$transaction_request_to_approve"
                wire:key="approve-form-{{ $transaction_request_to_approve?->id }}" />
        </x-modal>
    @endif

    <x-popup x-cloak x-show="selected_transaction_requests.length">
        <x-button.outline-button @click="clearSelected" class="!border">cancel</x-button.outline-button>
        <x-button.outline-button @click="bulkReject" class="!border">reject selected</x-button.outline-button>
        <x-button.filled-button @click="bulkApprove" class="!border">set for approval</x-button.filled-button>
    </x-popup>


    <x-modal.side-modal x-model="$wire.show_bulk_action_modal">
        @if (!empty($selected_transaction_requests) && isset($bulk_action))
            <livewire:merchant.financial-transaction.cash-outflow.cash-outflow-bulk-action :$merchant :selected_ids="$selected_transaction_requests"
                :action="$bulk_action" wire:key="bulk-action-{{ $bulk_action }}" />
        @endif
    </x-modal.side-modal>

</div>
@script
    <script>
        Alpine.data('pendingList', () => ({
            has_selected_all: false,
            selected_transaction_requests: [],
            current_page_transaction_request_ids: $wire.entangle('current_page_transaction_request_ids'),

            init() {
                this.$watch('current_page_transaction_request_ids', () => {
                    this.has_selected_all = this.validateHasSelectedAllClients();
                });

                this.$watch(() => [...this.selected_transaction_requests], () => {
                    this.has_selected_all = this.validateHasSelectedAllClients();
                });

                this.$wire.on('resetSelectedClientIds', () => {
                    this.selected_transaction_requests = [];
                    this.has_selected_all = false;
                });

                this.$wire.on('selectAllPendingTransactions', (ids) => {
                    this.selected_transaction_requests = ids[0];
                    this.has_selected_all = true;
                });

                this.$wire.on('clearBulkActionComponent', (ids) => {
                    this.selected_transaction_requests = [];
                });
            },

            validateHasSelectedAllClients() {
                return this.current_page_transaction_request_ids.length > 0 &&
                    this.current_page_transaction_request_ids.every(id => this.selected_transaction_requests
                        .map(Number)
                        .includes(Number(id)));
            },

            handleSelectAllOnChange(value) {
                if (value) {
                    this.selected_transaction_requests = [
                        ...new Set([...this.selected_transaction_requests.map(Number),
                            ...this.current_page_transaction_request_ids
                        ])
                    ];
                    this.has_selected_all = true;
                } else {
                    this.selected_transaction_requests = this.selected_transaction_requests.filter(
                        id => !this.current_page_transaction_request_ids.includes(Number(id))
                    );
                    this.has_selected_all = false;
                }
            },

            bulkApprove() {
                this.$wire.show_bulk_action_modal = true;
                this.$wire.callBulkApprove(this.selected_transaction_requests);
            },

            bulkReject() {
                this.$wire.show_bulk_action_modal = true;
                this.$wire.callBulkReject(this.selected_transaction_requests);
            },

            clearSelected() {
                this.selected_transaction_requests = [];
            },

            selectAllPendingTransactions() {
                this.$wire.selectAllPendingTransactions();
            },
        }));
    </script>
@endscript
