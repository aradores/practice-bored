<div>
    {{-- @vite(['resources/js/flatpickr.js']) --}}

    <div class="relative"
         x-data="date_time_picker('{{ $date_picker_id }}', '{{ $value ?? '' }}', '{{ $minDateEnabled ?? false }}')">

        <!-- Calendar icon -->
        <div class="absolute left-4 z-10 top-[50%] -translate-y-[50%]"
             @click="$refs.datetime_picker._flatpickr.open()">
            <x-icon.calendar-outline width="20" height="20" color="#647887" />
        </div>

        <!-- Input field -->
        <input type="text"
               id="{{ $date_picker_id }}"
               x-ref="datetime_picker"
               placeholder="{{ $placeholder }}"
               class="focus:outline-none flex flex-row items-center justify-between relative pl-11 pr-4 py-2 bg-white border border-rp-neutral-500 rounded-lg cursor-pointer w-[260px] min-w-full text-sm text-rp-neutral-700" />

        <!-- Arrow icon -->
        <div class="absolute right-4 z-10 top-[50%] -translate-y-[50%]">
            <div class="min-w-max">
                <x-icon.thin-arrow-down />
            </div>
        </div>
    </div>
</div>
