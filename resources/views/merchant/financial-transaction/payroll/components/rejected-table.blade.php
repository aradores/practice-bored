<x-table.standard class="overflow-auto max-w-full w-full">
    <x-slot:table_header class="text-rp-neutral-700 font-bold text-xs">
        {{-- Employee --}}
        <x-table.standard.th class="max-w-52">
            Employee
        </x-table.standard.th>

        {{-- Basic Salary --}}
        <x-table.standard.th class="max-w-52">
            <div class="flex flex-row items-center gap-2">
                <div>Basic Salary</div>
                @php
                    $gross_pay_sort_direction = '';

                    if ($sort_by === 'total_amount') {
                        $gross_pay_sort_direction = $sort_direction === 'desc' ? 'down' : 'up';
                    } else {
                        $gross_pay_sort_direction = 'both';
                    }
                @endphp
                <button wire:click="changeSorting('gross_pay')">
                    <x-icon.sort :direction="$gross_pay_sort_direction" height="26" width="18" />
                </button>
            </div>
        </x-table.standard.th>

        {{-- Salary Type --}}
        <x-table.standard.th class="max-w-52">
            Salary Type
        </x-table.standard.th>

        {{-- Net Pay --}}
        <x-table.standard.th class="max-w-40">
            <div class="flex flex-row items-center gap-2">
                <div>Net Pay</div>
                @php
                    $net_pay_sort_direction = '';

                    if ($sort_by === 'total_amount') {
                        $net_pay_sort_direction = $sort_direction === 'desc' ? 'down' : 'up';
                    } else {
                        $net_pay_sort_direction = 'both';
                    }

                @endphp
                <button wire:click="changeSorting('total_amount')">
                    <x-icon.sort :direction="$net_pay_sort_direction" height="26" width="18" />
                </button>
            </div>
        </x-table.standard.th>

        {{-- Payout Date --}}
        <x-table.standard.th class="max-w-52">
            <div class="flex flex-row items-center gap-2">
                <div>Payout Date</div>
                @php
                    $payout_at_sort_direction = '';

                    if ($sort_by === 'payout_at') {
                        $payout_at_sort_direction = $sort_direction === 'desc' ? 'down' : 'up';
                    } else {
                        $payout_at_sort_direction = 'both';
                    }

                @endphp
                <button wire:click="changeSorting('payout_at')">
                    <x-icon.sort :direction="$payout_at_sort_direction" height="26" width="18" />
                </button>
            </div>
        </x-table.standard.th>

        {{-- Rejected by --}}
        <x-table.standard.th class="max-w-52">
            <div class="flex flex-row items-center gap-2">
                <div>Rejected by</div>
                @php
                    $processor_name_sort_direction = '';

                    if ($sort_by === 'processor_name') {
                        $processor_name_sort_direction = $sort_direction === 'desc' ? 'down' : 'up';
                    } else {
                        $processor_name_sort_direction = 'both';
                    }

                @endphp
                <button wire:click="changeSorting('processor_name')">
                    <x-icon.sort :direction="$processor_name_sort_direction" height="26" width="18" />
                </button>
            </div>
        </x-table.standard.th>

        {{-- Created by --}}
        <x-table.standard.th class="max-w-52">
            <div class="flex flex-row items-center gap-2">
                <div>Created by</div>
                @php
                    $created_by_sort_direction = '';

                    if ($sort_by === 'creator_name') {
                        $created_by_sort_direction = $sort_direction === 'desc' ? 'down' : 'up';
                    } else {
                        $created_by_sort_direction = 'both';
                    }

                @endphp
                <button wire:click="changeSorting('creator_name')">
                    <x-icon.sort :direction="$created_by_sort_direction" height="26" width="18" />
                </button>
            </div>
        </x-table.standard.th>


        @if (empty($view_details))
            {{-- Reasons --}}
            <x-table.standard.th class="max-w-52">
                Reasons
            </x-table.standard.th>
            <x-table.standard.th class="max-w-40">
                Actions
            </x-table.standard.th>
        @else
            <x-table.standard.th class="max-w-20">
            </x-table.standard.th>
        @endif

    </x-slot:table_header>
    <x-slot:table_data>
        @foreach ($this->payrolls as $payroll)
            <x-table.standard.row>
                {{-- Employee Name --}}
                <x-table.standard.td class="max-w-52">
                    {{ $payroll->recipient_name }}
                </x-table.standard.td>

                {{-- Basic Salary --}}
                <x-table.standard.td class="max-w-52">
                    {{ Number::currency($payroll->gross_pay, 'PHP') }}
                </x-table.standard.td>

                {{-- Salary Type --}}
                <x-table.standard.td class="max-w-52">
                    {{ $payroll->salary_type->name }}
                </x-table.standard.td>

                {{-- Net Pay --}}
                <x-table.standard.td class="max-w-40 text-primary-800 font-bold">
                    {{ Number::currency($payroll->net_pay, 'PHP') }}
                </x-table.standard.td>

                {{-- Payout Date --}}
                <x-table.standard.td class="max-w-52">
                    {{ $payroll->payout_at ? \Carbon\Carbon::parse($payroll->payout_at)->timezone('Asia/Manila')->format('M d, Y h:i A') : 'Immediately' }}
                </x-table.standard.td>

                {{-- Rejected by --}}
                <x-table.standard.td class="max-w-52">
                    {{ $payroll->processor_name ?? 'Deleted employee' }}
                </x-table.standard.td>

                {{-- Created by --}}
                <x-table.standard.td class="max-w-52">
                    {{ $payroll->creator_name ?? 'Deleted employee' }}
                </x-table.standard.td>

                @if (empty($view_details))
                    {{-- Reason --}}
                    <x-table.standard.td class="max-w-52">
                        <div class="w-full flex flex-row" x-data="{
                            text: @js($payroll->reject_reason),
                            isFullTextShow: false
                        }">
                            <div class="w-[calc(100%-12px)]"
                                :class="!isFullTextShow && text.length >= 20 ?
                                    'text-ellipsis whitespace-nowrap overflow-hidden' : 'break-words'"
                                x-text="text">
                            </div>
                            <template x-if="text.length >= 20">
                                <span @click="isFullTextShow=!isFullTextShow" class="mt-[2px] h-max cursor-pointer">
                                    <template x-if="isFullTextShow === true">
                                        <x-icon.thin-arrow-up />
                                    </template>
                                    <template x-if="isFullTextShow === false">
                                        <x-icon.thin-arrow-down />
                                    </template>
                                </span>
                            </template>

                        </div>
                    </x-table.standard.td>
                    <x-table.standard.th class="max-w-40">
                        <button wire:click="showPayrollDetails('{{ $payroll->id }}')" class="p-2 rounded-full border border-rp-red-600 hover:bg-rp-red-50">
                            <x-icon.eye fill="#F70068" width="20" height="20" />
                        </button>
                    </x-table.standard.th>
                @else
                    <x-table.standard.td class="max-w-20">
                        <x-icon.chevron-right />
                    </x-table.standard.td>
                @endif
            </x-table.standard.row>
        @endforeach
    </x-slot:table_data>
</x-table.standard>
