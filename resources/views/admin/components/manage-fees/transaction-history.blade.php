<div>
    <div class="mt-4">
        <div class="search-filter w-full">
            <div class="date-picker flex gap-x-5 mt-4 flex xl:w-1/2">
                <x-input.search icon_position="left" wire:model.live='search' class="w-2/3" placeholder="Search by Transaction Number or Reference Number" />
                <div wire:ignore>
                    <x-date-picker.date-range-picker
                        id="transaction-history"
                        :from='null'
                        :to='null'
                        :maxDateToday="false"
                        placeholder="Select a date range"
                        class="w-1/3"
                    />
                </div>
            </div>
        </div>

        {{-- TODO: Fix parent container to allow auto overflow for smaller screen --}}

        <div class="mt-6 bg-white rounded-2xl w-full">
            <div class="overflow-auto w-full relative py-6 px-4 ">
                <div wire:loading.class="opacity-100 pointer-events-auto" wire:target="gotoPage, getTransactionFee" class="opacity-0 pointer-events-none absolute top-0 left-0 w-full h-full flex justify-center items-center transition-opacity duration-300 ease-in-out">
                    <div class="shadow-lg bg-rp-neutral-600/80 px-12 py-8 rounded">
                        <div class="inline-block h-8 w-8 animate-spin rounded-full border-4 border-solid border-current border-e-transparent align-[-0.125em] text-surface animate-spin dark:text-white"
                            role="status">
                            <span class="!absolute !-m-px !h-px !w-px !overflow-hidden !whitespace-nowrap !border-0 !p-0 ![clip:rect(0,0,0,0)]">Loading...</span>
                        </div>
                    </div>
                </div>

                <x-table.standard>
                    <x-slot:table_header class="text-rp-neutral-600 [&>*]:px-4 [&>*]:py-0 [&>*]:pb-3 [&>*]:text-nowrap">
                        {{-- <x-table.standard.th class="w-32">Date & Time</x-table.standard.th>
                        <x-table.standard.th class="w-32">Merchant</x-table.standard.th>
                        <x-table.standard.th class="w-40">Reference Number</x-table.standard.th>
                        <x-table.standard.th class="w-40">Transaction Number</x-table.standard.th>
                        <x-table.standard.th class="w-32">Fee Type</x-table.standard.th>
                        <x-table.standard.th class="w-32">Transaction Amount</x-table.standard.th>
                        <x-table.standard.th class="w-10">Fee</x-table.standard.th> --}}
                        @foreach ($header_columns as $col)
                            @if($col['show'])
                                <x-table.standard.th class="{{ $col['width'] }}">
                                    {{ $col['label'] }}
                                </x-table.standard.th>
                            @endif
                        @endforeach
                    </x-slot:table_header>

                    <x-slot:table_data>
                        @forelse ($transactionFees['data'] as $transactionFee)
                            {{-- <x-table.standard.row class="text-sm">
                                <x-table.standard.td> {{ $transactionFee['date_time'] ?? '-' }} </x-table.standard.td>
                                <x-table.standard.td> {{ $transactionFee['merchant_name'] ?? '-' }} </x-table.standard.td>
                                <x-table.standard.td> {{ $transactionFee['reference_number'] ?? '-' }} </x-table.standard.td>
                                <x-table.standard.td> {{ $transactionFee['transaction_number'] ?? '-' }} </x-table.standard.td>
                                <x-table.standard.td> {{ $transactionFee['fee_type'] ?? '-' }} </x-table.standard.td>
                                <x-table.standard.td> {{ $transactionFee['transaction_amount'] ?? '-' }} </x-table.standard.td>
                                <x-table.standard.td> {{ $transactionFee['fee'] ?? '-' }} </x-table.standard.td>
                            </x-table.standard.row> --}}
                            <x-table.standard.row class="text-sm">
                                @foreach ($header_columns as $col)
                                    @if($col['show'])
                                        <x-table.standard.td>
                                            {{ $transactionFee[$col['key']] ?? '-' }}
                                        </x-table.standard.td>
                                    @endif
                                @endforeach
                            </x-table.standard.row>
                        @empty
                            <tr colspan="full">
                                <td colspan="7" class="pt-8 pb-3 text-center align-middle">
                                    No records
                                </td>
                            </tr>
                        @endforelse
                    </x-slot:table_data>
                </x-table.standard>
                
                {{-- Pagination --}}
                <div class="pagination mt-4 flex justify-center font-bold">
                <div class="flex flex-row items-center h-10 gap-2 mt-4 w-max rounded-md overflow-hidden [&>*]:border [&>*]:rounded">
                    {{-- Previous Button --}}
                    <button
                        wire:click="previousPage"
                        {{ $transactionFees['pagination']['current_page'] == 1 ? 'disabled' : '' }}
                        class="{{ $transactionFees['pagination']['current_page'] == 1 ? 'cursor-not-allowed opacity-40' : '' }} px-4 h-full py-2 bg-white flex items-center">
                        <svg width="7" height="13" viewBox="0 0 7 13" fill="none">
                            <path d="M6 11.5001L1 6.50012L6 1.50012" stroke="#647887" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>

                    {{-- Page Number Buttons --}}
                    @foreach ($elements as $element)
                        @if (is_string($element))
                            <button class="h-full px-4 py-2 bg-white border-r cursor-default">{{ $element }}</button>
                        @else
                            <button
                                wire:click="gotoPage({{ $element }})"
                                class="h-full border px-4 py-2 {{ $element == $transactionFees['pagination']['current_page'] ? 'cursor-default text-primary-600 border-primary-600' : 'cursor-pointer bg-white' }}">
                                {{ $element }}
                            </button>
                        @endif
                    @endforeach

                    {{-- Next Button --}}
                    <button
                        wire:click="nextPage"
                        {{ $transactionFees['pagination']['current_page'] == $transactionFees['pagination']['last_page'] ? 'disabled' : '' }}
                        class="{{ $transactionFees['pagination']['current_page'] == $transactionFees['pagination']['last_page'] ? 'cursor-not-allowed opacity-40' : '' }} px-4 h-full py-2 border-r bg-white flex items-center">
                        <svg width="7" height="13" viewBox="0 0 7 13" fill="none">
                            <path d="M1 1.50012L6 6.50012L1 11.5001" stroke="#647887" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>