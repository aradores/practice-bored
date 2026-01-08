<div>
    <div class="card bg-white rounded-xl w-full p-5">
        <p class="text-[19.2px] font-bold">Schedule Future Fee changes</p>
        <div class="spacer my-4"></div>
        <livewire:admin.components.manage-fees.fee-form />
    </div>
</div>

{{-- PRODUCT LEFT   |    SERVICE RIGHT --}}
{{-- MARKUP         |       INVOICE --}}

{{-- active = text-primary-500 bg-primary-100 border-primary-500
not active = text-rp-neutral-600 bg-white border-transparent hover:bg-primary-100
default class = flex flex-col justify-center px-4 py-4 rounded-xl border-2 transition duration-300 w-1/2
--}}

{{-- REFERENC EONLY 
<button class="{{ request()->routeIs('admin.disputes.return-orders.index') ? 'text-primary-500 bg-primary-100 border-primary-500' : 'text-rp-neutral-600 bg-white border-transparent hover:bg-primary-100' }} flex flex-col justify-center px-4 py-4 rounded-xl border-2 transition duration-300 w-1/2">
    <span class="text-base break-words">Return Order Disputes</span>
    <span class="text-3.5xl font-bold break-words">Value etcetc</span>
</button> --}}