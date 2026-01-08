<div class="rounded-md p-4">
    <div class="p-2 rounded bg-white flex flex-row justify-between mb-2">
        <p class="text-lg">AllBank Transactions</p>

        <div class="flex flex-row gap-2">
            <p>Account</p>
            <select name="account" id="account" wire:model.live='account' class="rounded-md border border-black">
                <option value="p2m" selected>P2M</option>
                <option value="opc">OPC</option>
            </select>
        </div>
    </div>
    <div class="p-2 rounded bg-white flex flex-row justify-between mb-2">
        <div class="flex flex-col gap-2 w-1/2 text-lg">
            <p>
                @if ($error_msg)
                    <small class="text-red-500">
                        {{ $error_msg }}
                    </small>
                @endif
            </p>
            <p class="font-bold">Available Balance: {{ number_format($available, 2) }}</p>
            <p class="font-bold">Current Balance: {{ number_format($current, 2) }}</p>
        </div>
        <x-input.input-group class="w-1/6">
            <x-slot:label>End Date</x-slot:label>
            <x-input type="date" name="end_date" wire:model.change='end_date' onkeydown="return false" />
        </x-input.input-group>
    </div>

    <table class="w-full border-collapse mt-5 table-fixed bg-white rounded-md">
        <tr>
            <th class="text-left p-3 border min-w-5">Reference</th>
            <th class="text-left p-3 border min-w-5">Amount (PHP)</th>
            {{-- <th class="text-left p-3 border min-w-5">Running Balance (PHP)</th> --}}
            <th class="text-left p-3 border">Type</th>
            <th class="text-left p-3 border">Description</th>
            <th class="text-left p-3 border min-w-5">Status</th>
            <th class="text-left p-3 border min-w-5">Running Balance</th>
            <th class="text-left p-3 border min-w-5">Date</th>
        </tr>

        @if (empty($error) == false)
            <tr>
                <td class="p-2 border break-words bg-red-200" colspan="5">
                    {{ $error }}
                </td>
            </tr>
        @else
            @foreach ($records as $transaction)
                <tr>
                    <td class="p-2 border break-words">
                        {{ $transaction['reference'] }}
                        @if (!empty($transaction['senderRefid']))
                            <br>
                            Repay Ref ID: {{ $transaction['senderRefid'] }}
                        @endif
                    </td>
                    <td class="p-2 border break-words text-right">
                        {{ number_format($transaction['tranAmount'], 2) }}
                    </td>
                    {{-- <td class="p-2 border break-words text-right">
                        {{ number_format($transaction['runningBalance'], 2) }}
                    </td> --}}
                    <td class="p-2 border break-words">
                        {{ $transaction['tranType'] == 'C' ? 'Credit' : 'Debit' }}
                    </td>
                    <td class="p-2 border break-words">
                        {{ $transaction['tranDescription'] }}
                    </td>
                    <td class="p-2 border break-words">
                        {{ $transaction['ibftStatus'] }}
                    </td>
                    <td class="p-2 border break-words">
                        {{ number_format($transaction['runningBalance'], 2) }}
                    </td>
                    <td class="p-2 border break-words">
                        {{ Carbon\Carbon::parse($transaction['tranDate'])->format('m-d-y h:i A') }}
                    </td>
                </tr>
            @endforeach
        @endif
    </table>

    @if (session()->has('error'))
        <x-toasts.error />
    @endif
</div>
