@vite(['resources/js/flatpickr.js', 'resources/css/date-range-picker.css'])
<div class="relative" x-data="date_range_picker('{{ $date_picker_id }}', { from: '{{ $from }}', to: '{{ $to }}' }, {{ $maxDateToday }})">
    <div class="absolute left-4 z-10 top-[50%] -translate-y-[50%]">
        <x-icon.calendar-outline width="20" height="20" color="#647887" />
    </div>
    <input type="text" id="{{ $date_picker_id }}" placeholder="{{ $placeholder }}"
        class="focus:outline-none flex flex-row items-center justify-between relative pl-11 pr-4 py-2 bg-white border border-rp-neutral-500 rounded-lg cursor-pointer w-[260px] min-w-full text-sm text-rp-neutral-700" />
    <div class="absolute right-4 z-10 top-[50%] -translate-y-[50%]">
        <div class="min-w-max">
            <x-icon.thin-arrow-down />
        </div>
    </div>
</div>
