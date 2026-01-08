<x-main.content class="!px-16 !py-10">
    @vite(['resources/js/flatpickr.js'])
    @vite(['resources/css/referral-system.css'])
    <livewire:components.layout.admin.referral-system.referral-system-header />

    <div class="w-full rounded-2xl bg-white p-9 flex flex-col gap-9">
        <livewire:admin.referrals.settings.control-and-incentive />
        <livewire:admin.referrals.settings.faqs title="Standard Frequently Asked Questions" type="standard" />
        <livewire:admin.referrals.settings.faqs title="Merchant Frequently Asked Questions" type="merchant"  />
        <livewire:admin.referrals.settings.promo-banner type="standard_modal" />
        <livewire:admin.referrals.settings.promo-banner type="merchant_modal" />
        <livewire:admin.referrals.settings.promo-banner type="standard_banner" />
        <livewire:admin.referrals.settings.promo-banner type="merchant_banner" />
    </div>
</x-main.content>