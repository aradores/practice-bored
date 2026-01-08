<div class="flex flex-col gap-y-5">
    <div class="flex flex-col p-3 gap-y-1 rounded-2xl border transition duration-300 w-full text-start text-primary-700 bg-primary-100 border-primary-700">
        <div class="label flex">
            <x-icon.hand-cash width="18" height="18" stroke="currentColor" />
            <p class="ps-1 text-sm"">All</p>
        </div>

        <div class="total">
            <p class="text-2xl font-bold"> - Total Unsettled - </p>
        </div>

        <div class="balance">
            <p class="text-xs">Wallet Balance: {{ \Number::currency($this->latest_balance, 'PHP') }}</p>
        </div>
    </div>

    <div class="search-group md:w-1/2 flex gap-3">
        <x-input.search class="w-full" icon_position="left" wire:model.live.debounce.150ms="search" placeholder="Search by Reference Number" />
        <div wire:ignore>
            <x-date-picker.date-range-picker
                id="admin-merchant-unsettled-fees"
                :from='null'
                :to='null'
                :maxDateToday="false"
                placeholder="Select a date range"
            />
        </div>
    </div>

    <div class="px-3 py-5 bg-white rounded-2xl w-full relative overflow-auto">
        <x-table.standard>
            <x-slot:table_header class="text-rp-neutral-600 [&>*]:px-4 [&>*]:py-0 [&>*]:pb-3 [&>*]:text-nowrap">
                <x-table.standard.th class="w-40">Date & Time</x-table.standard.th>
                <x-table.standard.th class="w-40">Reference Number</x-table.standard.th>
                <x-table.standard.th class="w-40">Fee Type</x-table.standard.th>
                <x-table.standard.th class="w-40">Transaction Amount</x-table.standard.th>
                <x-table.standard.th class="w-20">Fee</x-table.standard.th>
                <x-table.standard.th class="w-40">Status</x-table.standard.th>
            </x-slot:table_header>

            <x-slot:table_data>
                @forelse ($unsettledFees['data'] as $unsettledFee)
                {{-- @dd($unsettledFees) --}}
                    <x-table.standard.row class="text-sm">
                        <x-table.standard.td> 
                            {{ $unsettledFee['date_time'] }}
                        </x-table.standard.td>
                        <x-table.standard.td> 
                            {{ $unsettledFee['reference_no'] }}
                        </x-table.standard.td>
                        <x-table.standard.td> 
                            {{ $unsettledFee['fee_type'] }}
                        </x-table.standard.td>
                        <x-table.standard.td> 
                            {{ $unsettledFee['amount'] }}
                        </x-table.standard.td>
                        <x-table.standard.td> 
                            {{ $unsettledFee['fee'] }}
                        </x-table.standard.td>
                        <x-table.standard.td> 
                            @if ($unsettledFee['status'] == 'Success')
                                <div class="p-1 bg-rp-green-200 border border-rp-green-600 text-rp-green-600 w-24 text-center text-xs rounded-lg">
                                Successful
                            </div>
                            
                            @elseif ($unsettledFee['status'] == 'Pending')
                                <div class="p-1 bg-rp-red-200 border border-rp-red-600 text-rp-red-600 w-24 text-center text-xs rounded-lg">
                                Pending
                            </div>

                            @endif
                            
                        </x-table.standard.td>
                    </x-table.standard.row>
                @empty
                    
                @endforelse
            </x-slot:table_data>
        </x-table.standard>
    </div>

    <div class="pagination flex justify-center">
        Pagination palceholder

        {{-- <div class="pagination mt-4 flex justify-center font-bold">
            <div class="flex flex-row items-center h-10 gap-2 mt-4 w-max rounded-md overflow-hidden [&>*]:border [&>*]:rounded">
                <!-- Previous Button -->
                <button
                    wire:click="previousPage"
                    {{ $change_history_records['pagination']['current_page'] == 1 ? 'disabled' : '' }}
                    class="{{ $change_history_records['pagination']['current_page'] == 1 ? 'cursor-not-allowed opacity-40' : '' }} px-4 h-full py-2 bg-white flex items-center">
                    <svg width="7" height="13" viewBox="0 0 7 13" fill="none">
                        <path d="M6 11.5001L1 6.50012L6 1.50012" stroke="#647887" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>

                <!-- Page Number Buttons -->
                @foreach ($elements as $element)
                    @if (is_string($element))
                        <button class="h-full px-4 py-2 bg-white border-r cursor-default">{{ $element }}</button>
                    @else
                        <button
                            wire:click="gotoPage({{ $element }})"
                            class="h-full border px-4 py-2 {{ $element == $change_history_records['pagination']['current_page'] ? 'cursor-default text-primary-600 border-primary-600' : 'cursor-pointer bg-white' }}">
                            {{ $element }}
                        </button>
                    @endif
                @endforeach

                <!-- Next Button -->
                <button
                    wire:click="nextPage"
                    {{ $change_history_records['pagination']['current_page'] == $change_history_records['pagination']['last_page'] ? 'disabled' : '' }}
                    class="{{ $change_history_records['pagination']['current_page'] == $change_history_records['pagination']['last_page'] ? 'cursor-not-allowed opacity-40' : '' }} px-4 h-full py-2 border-r bg-white flex items-center">
                    <svg width="7" height="13" viewBox="0 0 7 13" fill="none">
                        <path d="M1 1.50012L6 6.50012L1 11.5001" stroke="#647887" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>
            </div>
        </div> --}}
    </div>
</div>