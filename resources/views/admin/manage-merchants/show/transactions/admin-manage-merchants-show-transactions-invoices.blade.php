<x-main.content class="!px-16 !py-10" x-data="{
    invoiceDetailsModalVisible: false
}" x-init="function() {
    Livewire.on('showInvoiceDetails', function() {
        invoiceDetailsModalVisible = true;
    });
}">

    <livewire:components.layout.admin.merchant-details-header :merchant="$merchant" />

    <div class="mt-8">
        <x-card.display-balance title="Merchant Balance" :balance="$this->balance_amount" color="primary" class="mb-6" />

        <div class="flex">
            {{-- 1st Column: Left Sidebar --}}
            <x-layout.admin.merchant-details.transactions.left-sidebar :merchant="$merchant" class="w-60" />

            {{-- 2nd Column: Table --}}
            <div class="w-[calc(100%-240px)] pl-4">
                <div class="flex items-center gap-2 mb-5">
                    <p>Sort by:</p>
                    <x-dropdown.select-date wire:model.live='dateFilter' wire:loading.attr="disabled"
                        wire:loading.class='opacity-50'>
                        <x-dropdown.select-date.option value="">All transactions</x-dropdown.select-date.option>
                        <x-dropdown.select-date.option value="past_year">Past Year</x-dropdown.select-date.option>
                        <x-dropdown.select-date.option value="past_6_months">Past 6
                            Months</x-dropdown.select-date.option>
                        <x-dropdown.select-date.option value="past_30_days">Past 30 Days</x-dropdown.select-date.option>
                        <x-dropdown.select-date.option value="past_week">Past Week</x-dropdown.select-date.option>
                        <x-dropdown.select-date.option value="past_24_hours">Past 24
                            Hours</x-dropdown.select-date.option>
                    </x-dropdown.select-date>
                </div>

                {{-- Filter Cards --}}
                <div class="grid grid-cols-3 gap-3 mb-5">
                    <x-card.filter-card wire:click="$set('activeBox', 'unpaid')" :isActive="$activeBox === 'unpaid'" label="Unpaid"
                        :data="$this->unpaidInvoicesCount" color="primary" />
                    <x-card.filter-card wire:click="$set('activeBox', 'partial')" :isActive="$activeBox === 'partial'"
                        label="Partially Paid" :data="$this->partialInvoicesCount" color="primary" />
                    <x-card.filter-card wire:click="$set('activeBox', 'paid')" :isActive="$activeBox === 'paid'" label="Fully Paid"
                        :data="$this->paidInvoicesCount" color="primary" />
                </div>

                {{-- Search --}}
                <x-layout.search-container class="mb-5">
                    <x-input.search wire:model.live='searchTerm' icon_position="left" />
                </x-layout.search-container>

                {{-- Table --}}
                <div class="overflow-auto">
                    <x-table.rounded>
                        <x-slot:table_header>
                            <x-table.rounded.th>Recipient</x-table.rounded.th>
                            <x-table.rounded.th>
                                <div class="flex flex-row items-center">
                                    <span>Amount</span>
                                    <button wire:click="sortTable('final_price')">
                                        <x-icon.sort />
                                    </button>
                                </div>
                            </x-table.rounded.th>
                            <x-table.rounded.th>
                                <div class="flex flex-row items-center">
                                    <span>Date Created</span>
                                    <button wire:click="sortTable('created_at')">
                                        <x-icon.sort />
                                    </button>
                                </div>
                            </x-table.rounded.th>
                            <x-table.rounded.th>
                                <div class="flex flex-row items-center">
                                    <span>Due Date</span>
                                    <button wire:click="sortTable('due_date')">
                                        <x-icon.sort />
                                    </button>
                                </div>
                            </x-table.rounded.th>
                            <x-table.rounded.th>
                                Reference Number
                            </x-table.rounded.th>
                            <x-table.rounded.th>
                                Status
                            </x-table.rounded.th>
                        </x-slot:table_header>
                        <x-slot:table_data>
                            <tr>
                                <td class="pt-8"></td>
                            </tr>
                            @foreach ($invoices as $key => $invoice)
                                <x-table.rounded.row wire:click="handleTableRowClick({{ $invoice->id }})"
                                    wire:key='invoice-{{ $key }}'
                                    class="{{ false ? 'border border-primary-600' : 'hover:bg-rp-neutral-50 cursor-pointer' }}">
                                    <x-table.rounded.td>{{ $invoice->recipient }}</x-table.rounded.td>
                                    <x-table.rounded.td
                                        class="text-primary-600 font-bold">₱{{ number_format($invoice->final_price, 2) }}</x-table.rounded.td>
                                    <x-table.rounded.td>{{ \Carbon\Carbon::parse($invoice->created_at)->format('F d, Y') }}</x-table.rounded.td>
                                    <x-table.rounded.td>{{ \Carbon\Carbon::parse($invoice->due_date)->format('F d, Y') }}</x-table.rounded.td>
                                    <x-table.rounded.td>{{ $invoice->invoice_no }}</x-table.rounded.td>
                                    <x-table.rounded.td>
                                        @switch($invoice->status)
                                            @case('unpaid')
                                                <x-status color="neutral">Unpaid</x-status>
                                            @break

                                            @case('partial')
                                                <x-status color="yellow">Partially Paid</x-status>
                                            @break

                                            @case('paid')
                                                <x-status color="green">Paid</x-status>
                                            @break

                                            @default
                                                <x-status color="primary">{{ $invoice->status }}</x-status>
                                            @break
                                        @endswitch
                                    </x-table.rounded.td>
                                </x-table.rounded.row>
                            @endforeach
                        </x-slot:table_data>
                    </x-table.rounded>
                </div>

                {{-- Pagination --}}
                <div class="w-full flex items-end justify-end gap-8 mt-4">
                    @if ($invoices->hasPages())
                        <div class="flex flex-row items-center h-10 gap-0 mt-4 w-max border rounded-md overflow-hidden">
                            <button wire:click="previousPage" {{ $invoices->onFirstPage() ? 'disabled' : '' }}
                                class="{{ $invoices->onFirstPage() ? 'cursor-not-allowed opacity-50' : '' }} px-4 h-full py-2 border-r bg-white flex items-center">
                                <svg width="7" height="13" viewBox="0 0 7 13" fill="none">
                                    <path d="M6 11.5001L1 6.50012L6 1.50012" stroke="#647887" stroke-width="1.66667"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </button>
                            <!-- Pagination Elements -->
                            @foreach ($elements as $element)
                                <!-- "Three Dots" Separator -->
                                @if (is_string($element))
                                    <button
                                        class="h-full bg-white border-r px-4 py-2 cursor-default">{{ $element }}</button>
                                @else
                                    <button wire:click="gotoPage({{ $element }})"
                                        class="h-full bg-white border-r px-4 py-2 {{ $element == $invoices->currentPage() ? 'cursor-default' : 'cursor-pointer' }}">{{ $element }}</button>
                                @endif
                            @endforeach

                            <button wire:click="nextPage" {{ !$invoices->hasMorePages() ? 'disabled' : '' }}
                                class="{{ !$invoices->hasMorePages() ? 'cursor-not-allowed opacity-50' : '' }} px-4 h-full py-2 border-r bg-white flex items-center">
                                <svg width="7" height="13" viewBox="0 0 7 13" fill="none">
                                    <path d="M1 1.50012L6 6.50012L1 11.5001" stroke="#647887" stroke-width="1.66667"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Transaction Details Modal --}}
    <x-modal x-model="invoiceDetailsModalVisible">
        @isset($invoiceDetails)
            <div class="min-w-[35%] max-w-[35%] px-5 py-10 overflow-auto space-y-4 bg-white rounded-lg relative">
                <div class="absolute cursor-pointer top-4 right-3" @click="visible=false">
                    <x-icon.close />
                </div>
                <div class="flex flex-col justify-between gap-3">
                    @foreach ($invoiceDetails['items'] as $key => $item)
                        <div class="flex flex-row items-center justify-between">
                            <div>
                                <p>{{ $item['name'] }}</p>
                                <p class="text-sm">
                                    <span class="font-bold">{{ $item['price'] }}</span>
                                    <span>x {{ $item['quantity'] }}</span>
                                </p>
                            </div>
                            <div>
                                <p>{{ $item['total'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="flex flex-row items-center justify-between gap-3">
                    <p>Subtotal</p>
                    <p class="font-bold">{{ $invoiceDetails['subtotal'] }}</p>
                </div>

                @isset($invoiceDetails['inclusions'])
                    @foreach ($invoiceDetails['inclusions'] as $inclusion)
                        <div class="flex flex-row items-center justify-between gap-3">
                            <p>{{ $inclusion['name'] }}</p>
                            <p>{{ $inclusion['amount'] }}</p>
                        </div>
                    @endforeach
                @endisset

                <div class="flex flex-row items-center justify-between gap-3 font-bold">
                    <p>Total:</p>
                    <p class="text-lg">{{ $invoiceDetails['total'] }}</p>
                </div>

                @isset($invoiceDetails['partial_payment'])
                    <div class="flex flex-row items-center justify-between gap-3">
                        <p>Minimum partial payment allowed:</p>
                        <p>{{ $invoiceDetails['partial_payment'] }}</p>
                    </div>
                @endisset
            </div>
        @endisset
    </x-modal>

    {{-- Black Screen Overlay Loader --}}
    <x-loader.black-screen wire:loading.delay wire:loading.block wire:target="dateFilter,activeBox,sortTable"
        class="z-10" />
</x-main.content>
