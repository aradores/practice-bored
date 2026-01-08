<div class="max-w-[748px] w-[90%] p-6 bg-white rounded-2xl flex flex-col gap-5">
    <div class="flex flex-row items-center justify-between">
        <div class="text-neutral-700 font-bold text-2xl">
            Switch to Merchant Account
        </div>
        <button @click="visible=false">
            <x-icon.close />
        </button>
    </div>
    <div class="grid grid-cols-3 gap-3 max-h-[690px] overflow-y-auto">
        @foreach ($this->merchants as $merchant_employee)
            <div class="flex flex-col justify-between px-6 py-5 rounded-xl border shadow-sm">
                <div class="flex flex-col gap-2 items-center pb-7 border-b border-rp-neutral-300">
                    <div class="rounded-full overflow-hidden bg-white w-full max-w-32 min-h-32 h-full shadow-[0px_0px_16px_0px_rgba(0,0,0,0.1)]">
                        <img src="{{ $merchant_employee->logo_url }}" class="w-full h-full object-cover" />
                    </div>
                    <div class="flex flex-col items-center text-center justify-center">
                        <strong class="text-xl">{{ $merchant_employee->name }}</strong>
                        <span class="text-xs">Access level: 
                            <span class="text-rp-pink-500">
                                {{ ucwords(str_replace('_', ' ', $merchant_employee->employee_role_slug)) }}
                            </span>
                        </span>
                    </div>
                </div>
                <x-button.filled-button href="{{ $merchant_employee->redirect_url }}" class="w-full">switch</x-button.filled-button>
            </div>
        @endforeach
    </div>
    {{-- Pagination --}}
    <div class="flex justify-center">
        {{ $this->merchants->links('pagination.custom-pagination') }}
    </div>
</div>