<div x-data="{fee_type : 'markup'}">
    <div class="card bg-white rounded-xl w-full p-5">
        <p class="text-[19.2px] font-bold">Schedule Future Fee changes</p>
        <div class="spacer my-8"></div>
        <div class="type flex gap-2.5">

            <button @click="fee_type = 'markup' " x-bind:class="fee_type === 'markup' ? 'text-primary-700 bg-primary-100 border-primary-700' : 'text-rp-neutral-600 bg-white border-rp-neutral-600 hover:bg-primary-100' "
                class="flex flex-col px-4 py-4 rounded-xl border transition duration-300 w-1/2 text-start">
                <div class="label flex">
                    <x-icon.hand-cash width="16" height="16" stroke="currentColor" />
                    <p class="ps-1 text-sm" x-text="fee_type === 'markup' ? 'All' : 'Markup Rate'"></p>
                </div>
                <p class="text-2xl font-bold mt-1">50%</p>
            </button>

            <button @click="fee_type = 'invoice' " x-bind:class="fee_type === 'invoice' ? 'text-primary-700 bg-primary-100 border-primary-700' : 'text-rp-neutral-600 bg-white border-rp-neutral-600 hover:bg-primary-100' "
                class="flex flex-col px-4 py-4 rounded-xl border transition duration-300 w-1/2 text-start">
                <div class="label flex">
                    <x-icon.hand-cash width="16" height="16" stroke="currentColor" />
                    <p class="ps-1 text-sm" x-text="fee_type === 'invoice' ? 'All' : 'Invoice'"></p>
                </div>
                <p class="text-2xl font-bold mt-1">50%</p>
            </button>
        </div>
        <div class="spacer my-8"></div>
        <div x-show="fee_type === 'markup'" class="markup">Markup form</div>
        <div x-show="fee_type === 'invoice'" class="invoice">Invoice Type</div>

        <div class="flex flex-col gap-2.5 ">

            <div class="w-60 flex flex-col gap-5">
                {{-- <x-input.input-group >
                    <x-slot:label>Rate Type</x-slot:label>
                    <x-input type="text" name="text" />
                </x-input.input-group> --}}

                {{-- Todo - change to flat rate / percentage --}}
                <x-input.input-group >
                    <x-slot:label>Amount</x-slot:label>
                    <x-input type="text" name="text" />
                </x-input.input-group>

                {{-- Todo - use date picker to select date and time --}}
                <x-input.input-group >
                    <x-slot:label>Effective Date & Time</x-slot:label>
                    {{-- <x-input type="date" /> --}}
                    <div x-data="date_time_picker(null)" class="relative w-full">
                        
                        <div class="absolute top-1/2 translate-x-1/3 -translate-y-1/2" @click="$refs.datetime_picker._flatpickr.open()">
                            <x-icon.calendar-outline  />
                        </div>
                        <input
                            x-ref="datetime_picker"
                            type="text"
                            class="border border-gray-300 rounded-lg pl-10 pr-3 py-2 w-full focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                            placeholder="MM/DD/YYYY 00:00"
                        />
                    </div>

                    <span class="italic text-rp-red-400 text-xs text-nowrap my-2">Date must be at least 30 days later</span>
                </x-input.input-group>
            </div>

            <x-input.input-group >
                <x-slot:label>
                    <span class="text-[#E31C79]">*</span>
                    Reason for Custom Rate Alteration
                </x-slot:label>
                <x-input type="text" />
            </x-input.input-group>
        </div>
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