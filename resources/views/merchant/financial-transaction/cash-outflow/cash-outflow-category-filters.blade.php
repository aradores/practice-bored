<div class="flex flex-row flex-wrap gap-3 mb-8 w-full">
    <x-card.category-filter icon="hand-cash" :isActive="$active_box === ''" title="All" :count="$this->all_transactions['count']" :amount="$this->all_transactions['current']"
        :previous="$this->all_transactions['previous']" @click="$wire.set('active_box', '')" class="flex-1" />
    <x-card.category-filter icon="transaction" :isActive="$active_box === 'TR'" title="Money Transfer" :count="$this->transfer_transactions['count']"
        :amount="$this->transfer_transactions['current']" :previous="$this->transfer_transactions['previous']" @click="$wire.set('active_box', 'TR')" class="flex-1" />
    <x-card.category-filter icon="outline-bag" :isActive="$active_box === 'OR'" title="Order Payments" :count="$this->order_transactions['count']"
        :amount="$this->order_transactions['current']" :previous="$this->order_transactions['previous']" @click="$wire.set('active_box', 'OR')" class="flex-1" />
    <x-card.category-filter icon="invoice" :isActive="$active_box === 'IV'" title="Invoice Payments" :count="$this->invoice_transactions['count']"
        :amount="$this->invoice_transactions['current']" :previous="$this->invoice_transactions['previous']" @click="$wire.set('active_box', 'IV')" class="flex-1" />
    <x-card.category-filter icon="cash-in" :isActive="$active_box === 'CO'" title="Cash Out" :count="$this->cash_out_transactions['count']" :amount="$this->cash_out_transactions['current']"
        :previous="$this->cash_out_transactions['previous']" @click="$wire.set('active_box', 'CO')" class="flex-1"/>
    <x-card.category-filter icon="cash-wrapped" :isActive="$active_box === 'BP'" title="Bills" :count="$this->bill_transactions['count']" :amount="$this->bill_transactions['current']"
        :previous="$this->bill_transactions['previous']" @click="$wire.set('active_box', 'BP')" class="flex-1" />
    <x-card.category-filter icon="card" :isActive="$active_box === 'PS'" title="Payroll" :count="$this->payroll_transactions['count']" :amount="$this->payroll_transactions['current']"
        :previous="$this->payroll_transactions['previous']" @click="$wire.set('active_box', 'PS')" class="flex-1" />
    <x-card.category-filter icon="qr-code" :isActive="$active_box === 'QP'" title="QR Payments" :count="$this->qr_transactions['count']" :amount="$this->qr_transactions['current']"
        :previous="$this->qr_transactions['previous']" @click="$wire.set('active_box', 'QP')" class="flex-1" />
</div>
