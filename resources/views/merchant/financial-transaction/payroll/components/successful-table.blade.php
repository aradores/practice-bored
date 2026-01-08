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

                    if ($sort_by === 'gross_pay') {
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

                    if ($sort_by === 'net_pay') {
                        $net_pay_sort_direction = $sort_direction === 'desc' ? 'down' : 'up';
                    } else {
                        $net_pay_sort_direction = 'both';
                    }
                @endphp
                <button wire:click="changeSorting('net_pay')"><x-icon.sort :direction="$net_pay_sort_direction" height="26"
                        width="18" /></button>
            </div>
        </x-table.standard.th>

        {{-- Payout Date --}}
        <x-table.standard.th class="max-w-52">
            <div class="flex flex-row items-center gap-2">
                <div>Payout Date</div>
                @php
                    $processed_at_sort_direction = '';

                    if ($sort_by === 'processed_at') {
                        $processed_at_sort_direction = $sort_direction === 'desc' ? 'down' : 'up';
                    } else {
                        $processed_at_sort_direction = 'both';
                    }

                @endphp
                <button wire:click="changeSorting('processed_at')"><x-icon.sort :direction="$processed_at_sort_direction" height="26"
                        width="18" /></button>
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
                <button wire:click="changeSorting('creator_name')"><x-icon.sort :direction="$created_by_sort_direction" height="26"
                        width="18" /></button>
            </div>
        </x-table.standard.th>

        {{-- Approved by --}}
        <x-table.standard.th class="max-w-52">
            <div class="flex flex-row items-center gap-2">
                <div>Approved by</div>
                @php
                    $approved_by_sort_direction = '';

                    if ($sort_by === 'processor_name') {
                        $approved_by_sort_direction = $sort_direction === 'desc' ? 'down' : 'up';
                    } else {
                        $approved_by_sort_direction = 'both';
                    }

                @endphp
                <button wire:click="changeSorting('processor_name')"><x-icon.sort :direction="$created_by_sort_direction" height="26"
                        width="18" /></button>
            </div>
        </x-table.standard.th>

        @if (empty($view_details))
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
                    {{ \Carbon\Carbon::parse($payroll->processed_at)->timezone('Asia/Manila')->format('M d, Y h:i A') }}
                </x-table.standard.td>

                {{-- Created by --}}
                <x-table.standard.td class="max-w-52">
                    {{ $payroll->creator_name ?? 'Deleted employee' }}
                </x-table.standard.td>

                {{-- Approved by --}}
                <x-table.standard.td class="max-w-52">
                    {{ $payroll->processor_name ?? 'Deleted employee' }}
                </x-table.standard.td>

                {{-- Actions --}}
                @if (empty($view_details))
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
