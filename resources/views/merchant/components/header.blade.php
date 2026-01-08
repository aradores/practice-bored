<header
    class="px-5 py-2 max-h-[60px] min-h-[60px] border-b border-b-rp-neutral-100 flex flex-row justify-end items-center bg-white w-full" x-data="{ is_dropdown_open: false }">
    <div class="flex flex-row items-center gap-3">
        <div class="flex flex-row items-center gap-2" wire:ignore>
            <div>
                <img src="{{ $merchant_logo }}" alt="{{ $merchant->name }} logo"
                    class="object-cover w-11 h-11 rounded-full" />
            </div>
            <p>{{ $merchant->name }}</p>
        </div>
        <div class="relative" @click.away="is_dropdown_open = false">
            <button @click="is_dropdown_open = !is_dropdown_open" class="p-1.5 rounded-full hover:bg-rp-neutral-100"
                :class="is_dropdown_open ? 'bg-rp-neutral-100' : ''">
                <x-icon.solid-arrow-down />
            </button>
            <div x-cloak x-show="is_dropdown_open" class="absolute w-96 bg-white top-9 right-0 shadow-custom-dropdown rounded-lg z-20">
                <livewire:merchant.components.header-dropdown :$merchant />
            </div>
        </div>
    </div>
</header>
