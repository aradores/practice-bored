<div class="referrer-details relative p-6 flex flex-col gap-8">
    {{-- Upper section --}}
    <div class="flex flex-col gap-5">
        {{-- Filter date --}}
        <div class="flex flex-row gap-2.5 items-center justify-end">
            <div>Filter data by:</div>
            <div class="referrer-details-filter-date relative" x-data="referral_system_modal('{{ $display_date }}', { appendTo: document.querySelector('.referrer-details-filter-date') } )">
                <div class="absolute top-1/2 translate-x-1/3 -translate-y-1/2">
                    <x-icon.calendar-outline />
                </div>
                <input type="text" x-ref="month_filter"
                    class="w-full xl:w-max pl-9 rounded-lg border text-left focus:outline-none border-neutral-300 focus:!border-neutral-300 focus:ring-2 focus:ring-primary-500 focus:ring-offset-white focus:ring-offset-2 transition-all duration-200 p-2 h-full" />
            </div>
        </div>

        {{-- Profile pic --}}
        <div class="flex justify-center">
            <div class="w-[179px] h-[179px] max-w-[179px] max-h-[179px] rounded-full overflow-hidden">
                @if (isset($this->entity_referral_stats->logo_url) && $this->entity_referral_stats->logo_url)
                    <img src="{{ $this->entity_referral_stats->logo_url }}" alt=""
                        class="w-full h-full object-cover rounded-full">
                @else
                    <img src="{{ url('images/user/default-avatar.png') }}" alt=""
                        class="w-full h-full object-cover rounded-full">
                @endif
            </div>
        </div>

        {{-- Referrer basic details --}}
        <div class="flex flex-col items-center leading-tight">
            <div class="text-rp-neutral-700 font-bold text-2xl">{{ $this->entity_referral_stats->name }}</div>
            <div class="flex items-center text-rp-neutral-600 gap-1" x-data="clipboard">
                <div>Referral Code:</div>
                <button class="flex items-center gap-1" type="button" x-on:click="copy" x-cloak>
                    <div x-ref="referral_code">{{ $this->entity_referral_stats->referral_code }}</div>
                    <x-icon.copy />
                </button>
            </div>
            <a href="{{ $this->entity_referral_stats->profile_url }}" class="text-primary-500 underline">
                <div class="flex gap-1 items-center">Go to profile <x-icon.export /></div>
            </a>
        </div>

        {{-- Referrer stats --}}
        <div class="flex flex-row items-center justify-between">
            <div class="flex flex-col gap-1 leading-none">
                <div class="flex items-center gap-1">
                    <x-icon.info />
                    <span class="text-[11.11px]">Invitations Sent</span>
                </div>
                <div class="text-xl font-bold">{{ number_format($this->entity_referral_stats->invites_sent) }}</div>
            </div>
            <div class="flex flex-col gap-1 leading-none">
                <div class="flex items-center gap-1">
                    <x-icon.info />
                    <span class="text-[11.11px]">Standard Referrals</span>
                </div>
                <div class="text-xl font-bold">
                    {{ number_format($this->entity_referral_stats->standard_referrals_total) }}</div>
            </div>
            <div class="flex flex-col gap-1 leading-none">
                <div class="flex items-center gap-1">
                    <x-icon.info />
                    <span class="text-[11.11px]">Merchant Referrals</span>
                </div>
                <div class="text-xl font-bold">
                    {{ number_format($this->entity_referral_stats->merchant_referrals_total) }}</div>
            </div>
            <div class="flex flex-col gap-1 leading-none">
                <div class="flex items-center gap-1">
                    <x-icon.info />
                    <span class="text-[11.11px]">Incentives Received</span>
                </div>
                <div class="text-xl font-bold">
                    {{ Number::currency($this->entity_referral_stats->incentives_received, 'PHP') }}</div>
            </div>
        </div>
    </div>

    {{-- Referrals list section --}}
    <div class="flex flex-col gap-6">
        {{-- Button for referrals --}}
        <div class="flex text-[13.33px] border-b-[1.5px] border-rp-neutral-200">
            <button wire:click="$set('referral_tab', 'standard')"
                class="w-1/2 py-2.5 {{ $referral_tab == 'standard'
                    ? 'border-b-2 text-primary-600 font-bold border-primary-600'
                    : 'hover:border-b-2 hover:text-primary-600 hover:font-bold hover:border-primary-600' }}">
                Standard Referrals
            </button>
            <button wire:click="$set('referral_tab', 'merchant')"
                class="w-1/2 py-2.5 {{ $referral_tab == 'merchant'
                    ? 'border-b-2 text-primary-600 font-bold border-primary-600'
                    : 'hover:border-b-2 hover:text-primary-600 hover:font-bold hover:border-primary-600' }}">
                Merchant Referrals
            </button>
        </div>

        <div x-cloak x-show="$wire.referral_tab == 'standard'">
            <livewire:admin.referrals.referrers.referrer-details.standard-referrals :$entity_id :$entity_type
                :$start_date :$end_date lazy
                wire:key="standard-{{ $start_date->format('Y-m-d') . '-' . $end_date->format('Y-m-d') }}" />
        </div>

        <div x-cloak x-show="$wire.referral_tab == 'merchant'">
            <livewire:admin.referrals.referrers.referrer-details.merchant-referrals :$entity_id :$entity_type
                :$start_date :$end_date lazy
                wire:key="merchant-{{ $start_date->format('Y-m-d') . '-' . $end_date->format('Y-m-d') }}" />
        </div>
    </div>
</div>

@script
    <script>
        Alpine.data('clipboard', () => ({
            isCopied: false,

            init() {
                this.$watch('isCopied', value => {
                    this.$el.dataset.copied = value;
                });
            },

            async copy() {
                const textToCopy = this.$refs.referral_code?.innerText || this.$refs.referral_code?.value;

                if (!navigator.clipboard || !textToCopy || !await this.hasBrowserPermission()) {
                    return this.$wire.dispatch('notify', {
                        type: 'error',
                        title: 'Error',
                        message: "You did not have browser permissions to copy text"
                    });
                }

                try {
                    await navigator.clipboard.writeText(textToCopy);

                    // Reset all other copied states
                    document.querySelectorAll('[data-copied]').forEach(el => {
                        Alpine.evaluate(el, '$data.isCopied = false');
                    });

                    this.isCopied = true;
                    this.$wire.dispatch('notify', {
                        type: 'success',
                        title: 'Success!',
                        message: "Copied referral code '" + textToCopy + "'     to clipboard"
                    });
                } catch (err) {
                    this.$wire.dispatch('notify', {
                        type: 'error',
                        title: 'Error',
                        message: "Failed to copy text to clipboard"
                    });
                }
            },

            async hasBrowserPermission() {
                if (!navigator.permissions)
                    return true;

                try {
                    const result = await navigator.permissions.query({
                        name: 'clipboard-read'
                    });
                    return result.state === 'granted' || result.state === 'prompt';
                } catch {
                    return false;
                }
            }
        }));
    </script>
@endscript
