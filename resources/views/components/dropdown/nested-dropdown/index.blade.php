<div 
    {{ $attributes->merge(['class' => "relative w-auto min-w-48 text-sm text-rp-neutral-700"]) }}
    x-cloak
    x-data="{ isOpen: false, secondaryDropdown: null }">
    <button
        type="button"
        @click="isOpen = !isOpen"
        class="rounded-lg h-full w-full flex gap-3 items-center px-4 py-3 border border-rp-neutral-500 bg-white"
    >   
        <x-icon.funnel />
        <span>Filters</span>
    </button>

    <div 
        x-show="isOpen" 
        @click.outside="isOpen = false"
        class="absolute z-10 w-full mt-1 p-2 rounded-lg bg-white border border-rp-neutral-200"
    >
        {{ $slot }}
    </div>
</div>
