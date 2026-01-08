<div class="py-4 px-3 flex flex-col gap-4 divide-y divide-rp-neutral-100" x-data="{ is_merchant_list_open: $wire.entangle('is_merchant_list_open').live }">
    <div class="flex flex-col divide-y divide-rp-neutral-100">
        {{-- Current merchant --}}
        <div class="flex flex-row items-center gap-2 p-3">
            <div class="w-11 h-11 rounded-full overflow-hidden">
                <img src="{{ $this->merchant_logo }}" alt="{{ $merchant->name }} logo" class="object-cover w-full h-full">
            </div>
            <div class="text-rp-neutral-600 font-bold text-sm">{{ $merchant->name }}</div>
        </div>
        {{-- Other 5 active merchants --}}
        @if ($this->merchants->isNotEmpty())
            <div class="flex flex-col gap-2 pt-2">
                @foreach ($this->merchants as $other_merchant)
                    <a href="{{ $other_merchant->redirect_url }}"
                        class="p-3 flex flex-row items-center gap-2 justify-between rounded-lg hover:bg-rp-neutral-50">
                        <div class="flex flex-row items-center gap-2">
                            <div class="w-8 h-8 min-w-8 min-h-8 rounded-full overflow-hidden">
                                <img src="{{ $other_merchant->logo_url }}" class="object-cover w-full h-full"
                                    alt="{{ $other_merchant->name }} logo">
                            </div>
                            <div class="text-rp-neutral-600 font-bold text-sm">{{ $other_merchant->name }}</div>
                        </div>
                        <div>
                            <x-icon.change />
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>

    <div class="flex flex-col gap-4 pt-4">
        {{-- Other navigation items --}}
        @if ($this->merchants->isNotEmpty())
            <button class="p-3 flex flex-row items-center gap-1 rounded-lg hover:bg-rp-neutral-50"
                @click="is_merchant_list_open=true">
                <div class="w-6 h-6 overflow-hidden"><x-icon.user width="22" height="22" fill="#90A1AD" /></div>
                <div class="text-rp-neutral-500 text-sm">See all merchant accounts</div>
            </button>
        @endif
    
        <a href="{{ route('user.dashboard') }}"
            class="p-3 flex flex-row items-center gap-1 rounded-lg hover:bg-rp-neutral-50">
            <div class="w-6 h-6 overflow-hidden"><x-icon.user-octagon width="22" height="22" fill="#90A1AD" /></div>
            <div class="text-rp-neutral-500 text-sm">Switch to Individual Dashboard</div>
        </a>
    
        @if (auth()->user()->hasAdminRole())
            <a href="{{ route('admin.dashboard') }}"
                class="p-3 flex flex-row items-center gap-1 rounded-lg hover:bg-rp-neutral-50">
                <div class="w-6 h-6 overflow-hidden"><x-icon.crown width="22" height="22" fill="#90A1AD" /></div>
                <div class="text-rp-neutral-500 text-sm">Switch to Admin Dashboard</div>
            </a>
        @endif
    
        <button class="p-3 flex flex-row items-center gap-1 rounded-lg hover:bg-rp-neutral-50"
            @click.prevent="$refs.logout_form.submit()">
            <form x-ref="logout_form" method="POST" action="{{ route('logout') }}" class="hidden">
                @csrf
            </form>
            <div class="w-6 h-6 overflow-hidden"><x-icon.logout width="22" height="22" fill="#90A1AD" /></div>
            <div class="text-rp-neutral-500 text-sm">Log out</div>
        </button>
    </div>

    <x-modal x-model="is_merchant_list_open">
        @if ($is_merchant_list_open)
            <livewire:merchant.components.modals.switch-merchant-account :$merchant />
        @endif
    </x-modal>
</div>
