<div class="flex flex-row border-r h-full">
    <div class="flex-1 py-10 px-4 border-r border-rp-neutral-100">
        <x-breadcrumb :items="[
            [
                'label' => 'Cash Outflow',
                'href' => route('merchant.financial-transactions.cash-outflow.index', ['merchant' => $merchant]),
            ],
            ['label' => 'Create Transaction'],
        ]" />
        <h1 class="font-bold text-rp-neutral-700 text-2xl">Create Transaction</h1>
        <div class="flex flex-row gap-3 mt-8">
            <x-card.category icon="transaction" label="Money Transfer" description="Transfer to other RePay accounts."
                :isActive="$transaction_category === 'money-transfer'" @click="$wire.set('transaction_category', 'money-transfer')"
                class="flex-1 cursor-pointer" />

            <x-card.category icon="cash-in" label="Cash Out" description="Transfer to other Banks / eWallets."
                :isActive="$transaction_category === 'cash-out'" @click="$wire.set('transaction_category', 'cash-out')"
                class="flex-1 cursor-pointer" />

            <x-card.category icon="cash-wrapped" label="Bills" description="Pay your billers easily!" :isActive="$transaction_category === 'bill-payment'"
                @click="$wire.set('transaction_category', 'bill-payment')" class="flex-1 cursor-pointer" />
        </div>

        <livewire:dynamic-component :is="$this->component" :key="$this->component" :$merchant />
    </div>

    {{-- append summary component here --}}
    <div id="transactionSummary" class="min-w-[450px] h-full w-1/3"></div>
</div>
