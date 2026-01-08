<div class="p-2 bg-white  overflow-x-scroll">

    <div class="flex gap-2 p-2">

        <input type="text" wire:model.live.debounce.500ms="searchTerm"
            class="border border-gray-400 rounded-md p-2 mb-4 w-3/12" placeholder="Search Reference Number" />

        <select wire:model.live="type" class="border border-gray-400 rounded-md p-2 mb-4 w-48">
            @foreach ($allowedTypes as $type)
                <option value="{{ $type }}">{{ ucfirst(str_replace('_', ' ', $type)) }}</option>
            @endforeach
        </select>

        <span class="grow"></span>

        <div class="flex flex-col ">
            <p class="text-center mb-2">Page : {{ $transactions->currentPage() }}</p>
            {{ $transactions->links() }}
        </div>
    </div>


    {{-- Because she competes with no one, no one can compete with her. --}}
    <table class="min-w-full table-auto border-collapse border-1 border-gray-300 text-sm">
        <thead>
            <tr>
                <th class="font-bold p-2 border border-gray-300">Transaction Number</th>
                <th class="font-bold p-2 border border-gray-300">Referrence Number</th>
                <th class="font-bold p-2 border border-gray-300">Source</th>
                <th class="font-bold p-2 border border-gray-300">Recipient</th>
                <th class="font-bold p-2 border border-gray-300">Amount</th>
                <th class="font-bold p-2 border border-gray-300">Service Fee</th>
                <th class="font-bold p-2 border border-gray-300">Repay Cut</th>
                <th class="font-bold p-2 border border-gray-300">Provider</th>
                <th class="font-bold p-2 border border-gray-300">Channel</th>
                <th class="font-bold p-2 border border-gray-300">Type</th>
                <th class="font-bold p-2 border border-gray-300">Status</th>
                <th class="font-bold p-2 border border-gray-300">Created At</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transactions->items() as $transaction)
                <tr></tr>
                <td class="p-2 border border-gray-300 min-w-36">{{ $transaction->txn_no }}</td>
                <td class="p-2 border border-gray-300 min-w-36">
                    @if (!empty($transaction->extras['inv']))
                        INV: {{ $transaction->extras['inv'] ?? '' }}
                        <br>
                    @endif
                    Repay Ref ID: {{ $transaction->ref_no }}
                </td>
                <td class="p-2 border border-gray-300 min-w-36">
                    ID: {{ $transaction->sender->id }} <br>
                    Name: {{ $transaction->sender->name }} <br>
                    Type: {{ last(explode('\\', get_class($transaction->sender))) }}
                </td>
                <td class="p-2 border border-gray-300 min-w-36">
                    ID: {{ $transaction->recipient->id }} <br>
                    Name: {{ $transaction->recipient->name }} <br>
                    Type: {{ last(explode('\\', get_class($transaction->recipient))) }}
                </td>
                <td class="p-2 border border-gray-300 min-w-20">
                    {{ Number::currency($transaction->amount, $transaction->currency) }}
                </td>
                <td class="p-2 border border-gray-300 min-w-20">
                    {{ Number::currency($transaction->service_fee, $transaction->currency) }}
                </td>
                <td class="p-2 border border-gray-300 min-w-20">
                    {{ Number::currency($transaction->repay_cut, $transaction->currency) }}
                </td>
                <td class="p-2 border border-gray-300 min-w-20">{{ $transaction->provider->name }}</td>
                <td class="p-2 border border-gray-300 min-w-20">{{ $transaction->channel->name }}</td>
                <td class="p-2 border border-gray-300 min-w-20">{{ $transaction->type->name }}</td>
                <td class="p-2 border border-gray-300 min-w-20">{{ $transaction->status->name }}</td>
                <td class="p-2 border border-gray-300 min-w-48">
                    {{ \Carbon\Carbon::parse($transaction->created_at)->timezone('Asia/Manila')->format('M d Y h:i A') }}
                </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-5 flex justify-center">
        <div class="flex flex-col ">
            <p class="text-center mb-2">Page : {{ $transactions->currentPage() }}</p>
            {{ $transactions->links() }}
        </div>
    </div>
</div>
