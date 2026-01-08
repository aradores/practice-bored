<div class="p-6">
    {{-- Nothing in the world is as soft and yielding as water. --}}
    <div class="rounded-lg bg-white p-4">
        <p class="font-medium text-lg">EXTERNAL BALANCES</p>
        <p>- See Repay's external balance per provider <small class="italic">(if available)</small> </p>
    </div>

    <div class="flex flex-row gap-4">
        <a href="{{ route('admin.system-balances.allbank') }}" class="rounded-lg bg-white p-4 mt-4 min-w-36">
            <p class="font-medium text-lg mb-2">AllBank Disbursement Account</p>
            <p class="font-medium">Click to open &#x21C1</p>
        </a>

        <div class="rounded-lg bg-white p-4 mt-4 min-w-36">
            <p class="font-medium text-lg mb-2">ECPay Bills Payment Account</p>
            <p class="mt-2 font-medium text-xl">PHP {{ number_format($ecpay['bill_balance'], 2) }}</p>
        </div>

        {{-- <a href="{{ route('admin.system-balances.unionbank') }}" class="rounded-lg bg-white p-4 mt-4 min-w-36">
            <p class="font-medium text-lg mb-2">UnionBank &#x21C1</p>
        </a> --}}
        {{-- <div class="rounded-lg bg-white p-4 mt-4">
            <p class="font-medium text-lg mb-2">
                ALLBANK

                @if ($allbank['error_msg'])
                    (<small class="text-red-400">ERROR: {{ $allbank['error_msg'] }}</small>)
                @endif
            </p>
            <p class="font-medium text-xl">PHP {{ number_format($allbank['available_balance'], 2) }}</p>
            <p>Available Balance </p>
            <p class="mt-2 font-medium text-xl">PHP {{ number_format($allbank['current_balance'], 2) }}</p>
            <p>Current Balance </p>
            <div class="mt-2">
                <button type="button" wire:click="alb_p2m_transactions">
                    P2M TRANSACTIONS
                </button>
                <button type="button" wire:click="alb_opc_transactions" class="ml-2">
                    OPC TRANSACTIONS
                </button>
            </div>
        </div> --}}
        {{-- <div class="rounded-lg bg-white p-4 mt-4 min-w-36">
            <p class="font-medium text-lg mb-2">Buzzingga (SMS)</p>
            <p>Account A: {{ Number::format($buzzinga['OTP_balance'] / 100, 2) }}</p>
            <p>Account B: {{ Number::format($buzzinga['MKT_balance'] / 100, 2) }}</p>
        </div> --}}
    </div>
</div>
