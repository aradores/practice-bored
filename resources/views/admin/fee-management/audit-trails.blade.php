<div x-data>
    <div class="navigation flex gap-3 mb-3">
        <button 
            :class="auditTrailTab === 'change-history' ? 'text-primary-600 border-primary-600 bg-primary-100' : 'text-neutral-500 bg-white' "
            class="rounded-lg py-2 px-6 border"
            @click="auditTrailTab = 'change-history' ">Change History</button>
        <button 
        :class="auditTrailTab === 'transaction-history' ? 'text-primary-600 border-primary-600 bg-primary-100' : 'text-neutral-500 bg-white' "
            class="rounded-lg py-2 px-6 border"
            @click="auditTrailTab = 'transaction-history'" >Transaction History</button>
    </div>

    <div class="content">
        <div x-cloak class="change-history" x-show="auditTrailTab === 'change-history' ">
            <livewire:admin.components.manage-fees.change-history wire:key="audit-trail-change-history" />
        </div>
        <div x-cloak class="change-history" x-show="auditTrailTab === 'transaction-history'">
            <livewire:admin.components.manage-fees.transaction-history wire:key="audit-trail-transaction-history" />
        </div>
    </div>
</div>