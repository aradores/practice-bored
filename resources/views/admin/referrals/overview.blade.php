<x-main.content class="!px-16 !py-10">
    @vite(['resources/js/reusable-chart.js'])
    @vite(['resources/css/referral-system.css'])
    <livewire:components.layout.admin.referral-system.referral-system-header />

    <div class="mt-16 space-y-6">
        {{-- 1st row --}}
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
            <livewire:admin.referrals.overview.referral-shares :$sharesPerDay :$shares_count :$start_date
                wire:key="rflsh-{{ $start_date }}" />
            <livewire:admin.referrals.overview.referrers :$sharesPerDay :$referrers_count :$start_date
                wire:key="rfrs-{{ $start_date }}" />
            <livewire:admin.referrals.overview.standard-account-submissions :$start_date :total_users_count="$total_users_count"
                :referred_users="$referredUsers" wire:key="standard-account-submissions-{{ $start_date }}" />
        </div>
        {{-- 2nd row --}}
        <div class="grid grid-cols-1 xl:grid-cols-2 2xl:grid-cols-4 gap-6">
            <livewire:admin.referrals.overview.standard-accounts-created :$start_date :verified_users_count="$verified_users_count"
                :referred_users="$referredUsers" wire:key="standard-accounts-created-{{ $start_date }}" />
            <livewire:admin.referrals.overview.merchant-accounts-submitted :total="$verified_merchants_count + $pending_merchants_count" :$start_date
                :$referredMerchants wire:key="mas-{{ $start_date }}" />
            <livewire:admin.referrals.overview.merchant-accounts-onboarded :total="$verified_merchants_count" :$start_date
                :$referredMerchants wire:key="mao-{{ $start_date }}" />

            <livewire:admin.referrals.overview.successful-rate :$start_date :successful_referrals="$verified_merchants_count + $verified_users_count" :total_referrers="$referrers_count"
                :referred_users="$referredUsers" :referred_merchants="$referredMerchants" wire:key="osr-{{ $start_date }}" />
        </div>
        {{-- 3rd row --}}
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
            <livewire:admin.referrals.overview.merchant-successful-rate :$start_date :total_referrers="$referrers_count"
                :successful_referrals="$verified_merchants_count" :referrals="$referredMerchants" wire:key="msr-{{ $start_date }}" />

            <livewire:admin.referrals.overview.standard-successful-rate :$start_date :total_referrers="$referrers_count"
                :successful_referrals="$verified_users_count" :referrals="$referredUsers" wire:key="usr-{{ $start_date }}" />
        </div>
    </div>
</x-main.content>


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

        .flatpickr-next-month.flatpickr-disabled {
            cursor: default !important;
            opacity: 50%;
        }

        .flatpickr-next-month.flatpickr-disabled:hover svg {
            fill: inherit !important;
            cursor: default;
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

        .flatpickr-monthSelect-month.flatpickr-disabled {
            opacity: 50%;
        }

        .flatpickr-monthSelect-month.flatpickr-disabled:hover {
            background-color: initial;
            color: inherit;
            cursor: default;
        }
    </style>
@endpush
