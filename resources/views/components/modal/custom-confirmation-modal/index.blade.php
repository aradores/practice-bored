@props([
    'icon' => null,
    'title' => null,
    'message' => null,
])
<div {{ $attributes->merge(['class' => "relative max-w-[26rem] w-[90%] px-[24px] py-[26px] bg-white rounded-xl"]) }}>
    @if (!empty($icon))
        <div class="flex flex-row justify-between items-start mb-3">
            <x-dynamic-component component="icon.{{ $icon }}" />

            {{-- Close Button --}}
            <button class="p-2 hover:bg-rp-neutral-100 rounded-full" @click="$wire.dispatch('closeModal')">
                <x-icon.close-no-border />
            </button>
        </div>
    @else
        {{-- Close Button --}}
        <div class="absolute top-3 right-1">
            <button class="p-2 hover:bg-rp-neutral-100 rounded-full">
                <x-icon.close-no-border />
            </button>
        </div>
    @endif
    <div class="pb-4 border-b border-rp-neutral-100">
        <strong class="text-rp-neutral-700 text-2xl leading-10">{{ $title }}</strong>
        <p>{{ $message }}</p>
    </div>
    <div class="flex justify-end gap-2">
        @if ($footer->isNotEmpty())
            {{ $footer }}
        @endif
    </div>
</div>