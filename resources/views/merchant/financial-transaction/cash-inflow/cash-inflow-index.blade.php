<div class="w-full {{ isset($view_transaction) ? 'flex flex-row' : '' }}" x-data="cashInflowIndex">
    <div class="w-full py-10 px-4 {{ isset($view_transaction) ? 'border-r border-rp-neutral-100' : '' }}">
        @vite(['resources/js/cash-inflow-category-swiper.js'])
        <div class="flex flex-row items-center justify-between text-neutral-700">
            <h1 class="font-bold text-rp-neutral-700 text-2xl">Cash Inflow</h1>
            <div class="flex flex-row items-center gap-2.5">
                <x-date-picker.date-range-picker :from="$from_date" :to="$to_date" id="list" />

                <div id="export-card" class="relative">
                    <x-button.outline-icon-button title="Export" icon="icon.send-square" color="rp-red"
                        @click="show_export_form=!show_export_form" />
                    <div x-cloak x-show="show_export_form" class="absolute mt-1 right-0 z-10">
                        <livewire:merchant.financial-transaction.cash-inflow.cash-inflow-export :$merchant />
                    </div>
                </div>
            </div>
        </div>

        <div class="my-5">
            <x-card.overall-stats title="Money Received" :currentAmount="$this->present_money_received" :previousAmount="$this->previous_money_received" />
        </div>

        {{-- Swiper --}}
        {{-- <div class="cash-inflow-category-swiper !w-full my-3">
            <div class="swiper-wrapper !w-full">
                <x-card.category-filter title="All" count="108" amount="222" class="swiper-slide" />
                <x-card.category-filter title="All" count="108" amount="222" class="swiper-slide" />
                <x-card.category-filter title="All" count="108" amount="222" class="swiper-slide" />
                <x-card.category-filter title="All" count="108" amount="222" class="swiper-slide" />
                <x-card.category-filter title="All" count="108" amount="222" class="swiper-slide" />
            </div>
        </div> --}}

        <div class="flex flex-row items-stretch gap-2.5 mb-4 text-neutral-700">
            <x-input.search wire:model.live="search_sender" icon_position="left" placeholder="Search sender" />

            {{-- Amount Range Dropdown --}}
            <div role="button" x-data="{ isAmoundRangeDropdownOpen: false }" @click="isAmoundRangeDropdownOpen=true"
                class="relative w-48 pl-8 pr-5 py-2 flex items-center  border border-rp-neutral-500 rounded-lg bg-white hover:bg-rp-neutral-50">
                <div class="absolute top-[50%] left-2 -translate-y-[50%]">
                    <x-icon.filter />
                </div>
                <span class="text-center text-sm">Amount Range</span>
                <div class="absolute top-[50%] right-2 -translate-y-[50%]">
                    <x-icon.thin-arrow-down />
                </div>
                <div x-cloak x-show="isAmoundRangeDropdownOpen" @click.away="isAmoundRangeDropdownOpen=false"
                    class="absolute top-[100%] bg-white px-5 py-6 border shadow-lg w-96 right-0 rounded-xl">
                    <div class="flex flex-col gap-2 mb-5">
                        <x-input.input-group>
                            <x-slot:label>From</x-slot:label>
                            <x-input type="text" placeholder="0.00" x-mask:dynamic="$money($input)"
                                x-model="amount_min" />
                        </x-input.input-group>
                        <x-input.input-group>
                            <x-slot:label>To</x-slot:label>
                            <x-input type="text" placeholder="0.00" x-mask:dynamic="$money($input)"
                                x-model="amount_max" />
                        </x-input.input-group>
                    </div>
                    <div class="flex justify-end gap-2 w-full">
                        <x-button.outline-button
                            @click.stop="isAmoundRangeDropdownOpen=false">cancel</x-button.outline-button>
                        <x-button.outline-button
                            @click="amount_min=null;amount_max=null;">clear</x-button.outline-button>
                        <x-button.filled-button
                            @click.stop="applyAmount(amount_min,amount_max);isAmoundRangeDropdownOpen=false;">apply</x-button.filled-button>
                    </div>

                </div>
            </div>


        </div>

        <div class="flex flex-row gap-3 mb-8">
            <x-card.category-filter icon="hand-cash" :isActive="$active_box === ''" title="All" :count="$this->all_transactions['count']"
                :amount="$this->all_transactions['current']" :previous="$this->all_transactions['previous']" @click="$wire.set('active_box', '')" />
            <x-card.category-filter icon="transaction" :isActive="$active_box === 'TR'" title="Money Transfer" :count="$this->transfer_transactions['count']"
                :amount="$this->transfer_transactions['current']" :previous="$this->transfer_transactions['previous']" @click="$wire.set('active_box', 'TR')" />
            <x-card.category-filter icon="outline-bag" :isActive="$active_box === 'OR'" title="Order Payments" :count="$this->order_payment_transactions['count']"
                :amount="$this->order_payment_transactions['current']" :previous="$this->order_payment_transactions['previous']" @click="$wire.set('active_box', 'OR')" />
            <x-card.category-filter icon="cash-in" :isActive="$active_box === 'CI'" title="Cash In" :count="$this->cash_in_transactions['count']"
                :amount="$this->cash_in_transactions['current']" :previous="$this->cash_in_transactions['previous']" @click="$wire.set('active_box', 'CI')" />
            <x-card.category-filter icon="invoice" :isActive="$active_box === 'IV'" title="Invoice Payments" :count="$this->invoice_payment_transactions['count']"
                :amount="$this->invoice_payment_transactions['current']" :previous="$this->invoice_payment_transactions['previous']" @click="$wire.set('active_box', 'IV')" />
        </div>

        {{-- TODO: Cash Inflow Table --}}

        <div class="w-full flex flex-col gap-3 text-neutral-700">
            <div class="flex flex-col gap-3">
                {{-- Record and page buttons --}}
                <div class="flex flex-row justify-between items-center">
                    <div class="flex flex-row gap-2 items-center">
                        <span>Show</span>
                        <x-dropdown.select wire:model.live="records_per_page"
                            class="text-left appearance-none !px-0 !py-0">
                            <x-dropdown.select.option value="10">10</x-dropdown.select.option>
                            <x-dropdown.select.option value="20">20</x-dropdown.select.option>
                            <x-dropdown.select.option value="30">30</x-dropdown.select.option>
                            <x-dropdown.select.option value="40">40</x-dropdown.select.option>
                            <x-dropdown.select.option value="50">50</x-dropdown.select.option>
                        </x-dropdown.select>
                        <span>records</span>
                    </div>
                    @if ($this->transactions->hasPages())
                        <div class="flex flex-row gap-2.5">
                            <button wire:click="previousPage"
                                class="p-2 rounded-full {{ $this->transactions->onFirstPage() ? '' : 'hover:bg-rp-neutral-100' }}"
                                {{ $this->transactions->onFirstPage() ? 'disabled' : '' }}><x-icon.chevron-left
                                    color="{{ $this->transactions->onFirstPage() ? '#D3DADE' : '#647887' }}" /></button>
                            <button wire:click="nextPage"
                                class="p-2 rounded-full {{ $this->transactions->hasMorePages() ? 'hover:bg-rp-neutral-100' : '' }}"
                                {{ $this->transactions->hasMorePages() ? '' : 'disabled' }}><x-icon.chevron-right
                                    color="{{ $this->transactions->hasMorePages() ? '#647887' : '#D3DADE' }}" /></button>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Table --}}
            <div id="table_wrapper" class="overflow-auto w-full">
                <x-table.standard class="overflow-auto w-full">
                    <x-slot:table_header>
                        <x-table.standard.th class="max-w-52">
                            Transaction Type
                        </x-table.standard.th>
                        <x-table.standard.th class="max-w-52">
                            Sender
                        </x-table.standard.th>
                        <x-table.standard.th class="max-w-40">
                            <div class="flex flex-row items-center gap-2">
                                <div>Amount</div>
                                @php
                                    $amount_sort_direction = '';

                                    if ($sort_by === 'amount') {
                                        $amount_sort_direction = $sort_direction === 'desc' ? 'down' : 'up';
                                    } else {
                                        $amount_sort_direction = 'both';
                                    }

                                @endphp
                                <button wire:click="changeSorting('amount')"><x-icon.sort :direction="$amount_sort_direction" /></button>
                            </div>
                        </x-table.standard.th>
                        <x-table.standard.th class="max-w-52">
                            <div class="flex flex-row items-center gap-2">
                                <div>Date Received</div>
                                @php
                                    $date_received_sort_direction = '';

                                    if ($sort_by === 'created_at') {
                                        $date_received_sort_direction = $sort_direction === 'desc' ? 'down' : 'up';
                                    } else {
                                        $date_received_sort_direction = 'both';
                                    }

                                @endphp
                                <button wire:click="changeSorting('created_at')"><x-icon.sort
                                        :direction="$date_received_sort_direction" /></button>
                            </div>
                        </x-table.standard.th>
                        <x-table.standard.th class="max-w-52">
                            Reference Number
                        </x-table.standard.th>
                        <x-table.standard.th class="max-w-40">
                            <div x-ref="status_button" class="flex flex-row items-center gap-2 relative"
                                @click.away="show_status_filters=false">
                                <div>
                                    Status
                                </div>
                                <div class="relative" x-data="{ x: 0, y: 0 }">
                                    <button
                                        @click="() => {
                                                const rect = $el.getBoundingClientRect();
                                                x = rect.left;
                                                y = rect.bottom;
                                                show_status_filters=!show_status_filters;
                                            }"
                                        class="p-2 hover:rounded-full hover:bg-rp-neutral-100"
                                        :class="{ 'bg-rp-neutral-100 rounded-full': show_status_filters }"><x-icon.filter /></button>
                                    <template x-teleport="body">
                                        <div x-cloak x-show="show_status_filters" @click.stop
                                            :style="`position: fixed; top: ${y}px; left: ${x}px; transform: translateX(-85%);`"
                                            class="absolute w-52 bg-white rounded-lg py-4 px-3 flex flex-col gap-2 shadow-md text-sm font-normal">
                                            <div class="p-3 flex flex-row gap-2 justify-between items-center w-full">
                                                <x-transaction.status-pill status="successful" />
                                                <input type="checkbox" wire:model.live="selected_statuses"
                                                    value="successful" class="w-4 h-6" name="status_pending" />
                                            </div>
                                            <div class="p-3 flex flex-row gap-2 justify-between items-center w-full">
                                                <x-transaction.status-pill status="pending" />
                                                <input type="checkbox" wire:model.live="selected_statuses"
                                                    value="pending" class="w-4 h-6" />
                                            </div>
                                            <div class="p-3 flex flex-row gap-2 justify-between items-center w-full">
                                                <x-transaction.status-pill status="failed" />
                                                <input type="checkbox" wire:model.live="selected_statuses"
                                                    value="failed" class="w-4 h-6" />
                                            </div>
                                            <div class="p-3 flex flex-row gap-2 justify-between items-center w-full">
                                                <x-transaction.status-pill status="refunded" />
                                                <input type="checkbox" wire:model.live="selected_statuses"
                                                    value="refunded" class="w-4 h-6" />
                                            </div>
                                        </div>
                                    </template>
                                </div>

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
                            <x-table.standard.row class="text-neutral-600">
                                <x-table.standard.td class="max-w-52">
                                    {{ $transaction->type->name }}
                                </x-table.standard.td>
                                <x-table.standard.td class="max-w-52">
                                    {{ $transaction->sender_name }}
                                </x-table.standard.td>
                                <x-table.standard.td class="max-w-40">
                                    {{ Number::currency($transaction->amount, $transaction->currency) }}
                                </x-table.standard.td>
                                <x-table.standard.td class="max-w-52">
                                    {{ \Carbon\Carbon::parse($transaction->created_at)->timezone('Asia/Manila')->format('F j, Y') }}
                                </x-table.standard.td>
                                <x-table.standard.td class="max-w-52">
                                    {{ $transaction->ref_no }}
                                </x-table.standard.td>
                                <x-table.standard.td class="max-w-40">
                                    <x-transaction.status-pill :status="$transaction->status->slug" />
                                </x-table.standard.td>
                                @empty($view_transaction)
                                    <x-table.standard.td class="max-w-40">
                                        <button wire:click="showTransactionDetails('{{ $transaction->txn_no }}')"
                                            class="p-2 rounded-full border border-rp-red-600 hover:bg-rp-red-50">
                                            <x-icon.eye fill="#F70068" />
                                        </button>
                                    </x-table.standard.td>
                                @endempty
                                @if (isset($view_transaction) && $transaction->txn_no == $view_transaction->txn_no)
                                    <x-table.standard.td class="max-w-40">
                                        <x-icon.chevron-right />
                                    </x-table.standard.td>
                                @else
                                    <x-table.standard.td class="max-w-40">
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
        </div>
    </div>

    @isset($view_transaction)
        <div class="p-5">
            <livewire:merchant.financial-transaction.cash-inflow.cash-inflow-transaction-details :transaction="$view_transaction"
                wire:key="cash-inflow-transaction-{{ $view_transaction->txn_no }}" />
        </div>
    @endisset

    {{-- <div class="w-[300px] h-full"></div> --}}
</div>
@script
    <script>
        Alpine.data('cashInflowIndex', () => ({
            show_export_form: false,

            amount_min: null,
            amount_max: null,

            show_status_filters: false,

            init() {
                this.$wire.on('closeCashInflowExportModal', () => {
                    this.show_export_form = false;
                });
            },

            applyAmount() {
                this.$wire.applyAmounts(this.amount_min, this.amount_max);
            }
        }));
    </script>
@endscript
