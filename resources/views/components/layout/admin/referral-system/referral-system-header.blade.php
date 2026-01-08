<div class="referral-system-header flex flex-col gap-11 mb-11">
    @vite(['resources/js/flatpickr.js'])
    <x-main.title>Referral System</x-main.title>
    <livewire:admin.referrals.balance-banner />
    <div class="flex flex-col xl:flex-row gap-11">
        <x-tab class="xl:grow border-b-2" wire:ignore>
            <x-tab.tab-item href="{{ route('admin.referrals.index') }}" :isActive="request()->routeIs('admin.referrals.index')" color="primary"
                class="w-[162px]">Overview</x-tab.tab-item>
            <x-tab.tab-item href="{{ route('admin.referrals.referrers') }}" :isActive="request()->routeIs('admin.referrals.referrers')" color="primary"
                class="w-[162px]">Referrers</x-tab.tab-item>
            <x-tab.tab-item href="{{ route('admin.referrals.settings') }}" :isActive="request()->routeIs('admin.referrals.settings')" color="primary"
                class="w-[162px]">Settings</x-tab.tab-item>
        </x-tab>

        <div class="flex flex-col xl:flex-row xl:items-center gap-2.5" >
            <div>Filter by:</div>
            <div class="referrer-filter-date relative" x-data="referral_system({ appendTo: document.querySelector('.referrer-filter-date') })">
                <div class="absolute top-1/2 translate-x-1/3 -translate-y-1/2">
                    <x-icon.calendar-outline />
                </div>
                <input type="text" x-ref="month_filter" {{ $filterDateDisabled ? 'disabled' : '' }}
                    class="w-full xl:w-max pl-9 rounded-lg border text-left focus:outline-none border-neutral-300 focus:!border-neutral-300 focus:ring-2 focus:ring-primary-500 focus:ring-offset-white focus:ring-offset-2 transition-all duration-200 p-2 h-full" />
            </div>
        </div>
    </div>
</div>
@push('styles')
    <style>
        .flatpickr-calendar {
            padding: 8px 4px !important;
        }

        .flatpickr-rContainer {
            display: block !important;
        }

        .flatpickr-months {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            padding: 0 4px !important;
        }

        .flatpickr-month {
            display: flex !important;
            align-items: center !important;
        }

        .flatpickr-prev-month {
            display: flex !important;
            align-items: center !important;
            padding: 0px !important;
            position: relative !important;
        }

        .flatpickr-next-month {
            display: flex !important;
            align-items: center !important;
            padding: 0px !important;
            position: relative !important;
        }

        .flatpickr-current-month {
            display: flex !important;
            margin: 0 auto !important;
            align-items: center !important;
            justify-content: center !important;
            padding-top: 0 !important;
        }

        .flatpickr-innerContainer {
            display: block !important;
            width: 100% !important;
            margin-top: 8px;
        }

        .flatpickr-monthSelect-months {
            display: grid !important;
            gap: 2px;
            grid-template-columns: repeat(3, 1fr) !important;
            place-content: center;
            width: 100% !important;
        }

        .flatpickr-monthSelect-month {
            padding: 8px 4px !important;
            cursor: pointer;
            border-radius: 8px;
        }

        .flatpickr-monthSelect-month:hover {
            background-color: #7f56d9;
            color: #ffff;
        }

        .flatpickr-monthSelect-month.selected {
            background-color: #7f56d9 !important;
            color: #ffff;
        }

        .flatpickr-disabled {
            color: #BBC5CD;
        }

        .flatpickr-disabled:hover {
            background-color: #BBC5CD !important;
        }
    </style>
@endpush
