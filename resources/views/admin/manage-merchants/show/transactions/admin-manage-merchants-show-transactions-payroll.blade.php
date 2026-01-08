<x-main.content class="!px-16 !py-10">
    <livewire:components.layout.admin.merchant-details-header :merchant="$merchant" />

    <div class="mt-8">
        <x-card.display-balance title="Merchant Balance" :balance="$merchant->latest_balance?->amount ?? 0.0" color="primary" class="mb-6" />

        <div class="flex">
            {{-- 1st Column: Left Sidebar --}}
            <x-layout.admin.merchant-details.transactions.left-sidebar :merchant="$merchant" class="w-60" />

            {{-- 2nd Column: Table --}}
            <div class="w-[calc(100%-240px)] pl-4 space-y-8">
                <x-layout.search-container>
                    <x-input.search wire:model.live='searchTerm' icon_position="left" />
                </x-layout.search-container>

                <div>
                    <x-table.rounded>
                        <x-slot:table_header>
                            <x-table.rounded.th>Employee</x-table.rounded.th>
                            <x-table.rounded.th>
                                <div class="flex flex-row items-center">
                                    <span>Base Salary</span>
                                    <button wire:click="sortTable('salary')">
                                        <x-icon.sort />
                                    </button>
                                </div>
                            </x-table.rounded.th>
                            <x-table.rounded.th>
                                <div class="flex flex-row items-center">
                                    <span>Salary Type</span>
                                </div>
                            </x-table.rounded.th>
                            {{-- <x-table.rounded.th>
                            <div class="flex flex-row items-center">
                                <span>Deductions</span>
                                <div class="cursor-pointer" wire:click="sortTable('total_deductions')">
                                    <x-icon.sort />
                                </div>
                            </div>
                        </x-table.rounded.th> --}}
                            {{-- <x-table.rounded.th>
                            <div class="flex flex-row items-center">
                                <span>SSS</span>
                                <div class="cursor-pointer" wire:click="sortTable('sss_deduction')">
                                    <x-icon.sort />
                                </div>
                            </div>
                        </x-table.rounded.th> --}}
                            <x-table.rounded.th>
                                <div class="flex flex-row items-center">
                                    <span>Net Pay</span>
                                    <button wire:click="sortTable('amount')">
                                        <x-icon.sort />
                                    </button>
                                </div>
                            </x-table.rounded.th>
                            <x-table.rounded.th>
                                <div class="flex flex-row items-center">
                                    <span>Sent Date</span>
                                    <button wire:click="sortTable('transactions.created_at')">
                                        <x-icon.sort />
                                    </button>
                                </div>
                            </x-table.rounded.th>
                        </x-slot:table_header>
                        <x-slot:table_data>
                            <tr>
                                <td class="pt-8"></td>
                            </tr>
                            @foreach ($payroll_transactions as $key => $payroll)
                                <x-table.rounded.row wire:key="payroll-{{ $key }}">
                                    <x-table.rounded.td class="flex flex-col">
                                        {{ $payroll->recipient->name }}
                                    </x-table.rounded.td>
                                    <x-table.rounded.td>
                                        {{ \Number::currency($payroll->salary, 'PHP') }}
                                    </x-table.rounded.td>
                                    <x-table.rounded.td>
                                        {{ $payroll->recipient->employee->first()->salary_type->name }}
                                    </x-table.rounded.td>
                                    <x-table.rounded.td class="text-primary-600 font-bold">
                                        {{ \Number::currency($payroll->amount, 'PHP') }}
                                    </x-table.rounded.td>
                                    <x-table.rounded.td>
                                        {{ \Carbon\Carbon::parse($payroll->created_at)->timezone('Asia/Manila')->format('F j, Y - h:i A') }}
                                    </x-table.rounded.td>
                                </x-table.rounded.row>
                            @endforeach
                        </x-slot:table_data>
                    </x-table.rounded>
                </div>

                {{-- Pagination --}}
                <div class="flex items-center justify-center w-full gap-8">
                    {{ $payroll_transactions->links('pagination.custom-pagination') }}
                </div>
            </div>
        </div>
    </div>
</x-main.content>
