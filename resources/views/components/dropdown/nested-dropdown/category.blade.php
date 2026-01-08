@props(['title','id'])

<div x-cloak {{ $attributes->merge(['class' => "relative my-1  "]) }} >
    <div class="dropdown-container rounded overflow-hidden [&>*]:p-1 duration-300">
        <button
            type="button"
            @click="secondaryDropdown = secondaryDropdown === `{{ $id }}` ? null : `{{ $id }}`"

            class="w-full flex justify-between items-center p-1"
            :class="secondaryDropdown === '{{ $id }}' ? 'bg-rp-neutral-300' : 'bg-white' ">
            <span class="indent-1">{{ $title }}</span>
        </button>

        <div
            x-cloak
            x-show="secondaryDropdown === '{{ $id }}'"
            class="w-full flex flex-col"
            :class="secondaryDropdown === '{{ $id }}' ? 'bg-rp-neutral-100' : '' ">
            {{ $slot }}
        </div>
    </div>
</div>
