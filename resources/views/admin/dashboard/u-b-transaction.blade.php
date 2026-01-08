<div class="p-4">
    {{-- Care about people's approval and you will be their prisoner. --}}


    <div class="p-2 rounded bg-white flex flex-row justify-between mb-2">
        <div class="flex flex-col gap-2 w-1/2 text-lg">
            <p>Union Bank transactions</p>
            <p class="font-bold">Latest Balance: {{ number_format($lastRunningBalance, 2) }}</p>
        </div>
        <div class="flex flex-row gap-2 w-1/2">
            <x-input.input-group class="w-1/2">
                <x-slot:label>From</x-slot:label>
                <x-input type="date" name="from_date" wire:model.change='fromDate' onkeydown="return false"
                    max="{{ Carbon\Carbon::parse($toDate)->subDay()->format('Y-m-d') }}" />
            </x-input.input-group>
            <x-input.input-group class="w-1/2">
                <x-slot:label>To</x-slot:label>
                <x-input type="date" name="to_date" wire:model.change='toDate' onkeydown="return false"
                    min="{{ Carbon\Carbon::parse($fromDate)->addDay()->format('Y-m-d') }}" />
            </x-input.input-group>
        </div>
    </div>

    <table class="w-full border-collapse mt-5 table-fixed bg-white">
        <tr>
            <th class="text-left p-3 border min-w-5">ID</th>
            <th class="text-left p-3 border min-w-5">Amount</th>
            <th class="text-left p-3 border min-w-5">Type</th>
            <th class="text-left p-3 border min-w-5">Date</th>
            <th class="text-left p-3 border min-w-5">Posted</th>
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
                    <td class="p-2 border break-words ">
                        {{ $transaction['tranId'] }}
                    </td>
                    <td class="p-2 border break-words ">
                        {{ $transaction['currency'] }} {{ $transaction['amount'] }}
                    </td>
                    <td class="p-2 border break-words ">
                        {{ $transaction['tranType'] == 'C' ? 'Credit' : 'Debit' }}
                    </td>
                    <td class="p-2 border break-words ">
                        {{ Carbon\Carbon::parse($transaction['tranDate'])->format('Y-m-d h:i:s') }}
                    </td>
                    <td class="p-2 border break-words ">
                        {{ Carbon\Carbon::parse($transaction['postedDate'])->format('Y-m-d h:i:s') }}
                    </td>
                </tr>
            @endforeach
        @endif
    </table>

    @if (session()->has('error'))
        <x-toasts.error />
    @endif
</div>
