<div>
    @include('merchant.financial-transaction.cash-outflow.cash-outflow-category-filters')

    @include('merchant.financial-transaction.cash-outflow.cash-outflow-pagination-config')

    {{-- Table --}}
    <div id="table_wrapper" class="overflow-auto w-full">
        <x-table.standard class="overflow-auto w-full">
            <x-slot:table_header>
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
                    Reference Number
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
                        <x-table.standard.td class="max-w-52">
                            {{ $transaction->type->name }}
                        </x-table.standard.td>
                        <x-table.standard.td class="max-w-52">
                            {{ $transaction->provider->name }}
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
                            {{ $transaction->ref_no }}
                        </x-table.standard.td>
                        <x-table.standard.td class="max-w-52">
                            {{ $transaction->employee_name ?? '-' }}
                        </x-table.standard.td>
                        @empty($view_transaction)
                            <x-table.standard.td class="max-w-40">
                                <button wire:click="showTransactionDetails('{{ $transaction->id }}')"
                                    class="p-2 rounded-full border border-rp-red-600 hover:bg-rp-red-50">
                                    <x-icon.eye fill="#F70068" width="20" height="20" />
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
        {{ $this->transactions->links('pagination.custom-pagination') }}
    </div>

    @if (!empty($view_transaction))
        <template x-teleport="#transaction_detail">
            <livewire:merchant.financial-transaction.cash-outflow.transaction-details :transaction="$view_transaction"
                wire:key="approved-txn-{{ $view_transaction->id }}" />
        </template>
    @endif
</div>
