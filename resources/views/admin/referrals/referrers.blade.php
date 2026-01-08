<x-main.content class="!px-16 !py-10 relative" x-data="referrer_details_ui">
    @vite(['resources/js/flatpickr.js'])
    @vite(['resources/js/reusable-chart.js'])
    @vite(['resources/css/referral-system.css'])
    <livewire:components.layout.admin.referral-system.referral-system-header />

    <div class="flex flex-col gap-5">
        {{-- Search bar --}}
        <form wire:submit="updateSearch" class="flex flex-row gap-2.5">
            <x-input.search wire:model="search_input" placeholder="Search by name, email, contact"
                class="w-[325px] !border-rp-neutral-500 !rounded-lg" />
            <x-button.filled-button type="submit" color="primary-gradient" class="w-[161px] py-2.5">
                <span class="text-[13.33px]">Search</span>
            </x-button.filled-button>
        </form>

        {{-- Filter by type --}}
        <div class="flex flex-row gap-4">
            <button wire:click="switchTab('standard')"
                class="py-2.5 px-6 rounded-lg w-fit border-2 focus:border-primary-500 active:border-primary-500 focus:outline-none
                {{ $tab == 'standard'
                    ? 'bg-primary-100 text-primary-500 border-primary-500'
                    : 'bg-white text-rp-neutral-600 border-white hover:border-primary-500' }}
                ">
                Standard Referrers
            </button>

            <button wire:click="switchTab('merchant')"
                class="py-2.5 px-6 rounded-lg w-fit border-2 focus:border-primary-500 active:border-primary-500  focus:outline-none
                {{ $tab == 'merchant'
                    ? 'bg-primary-100 text-primary-500 border-primary-500'
                    : 'bg-white text-rp-neutral-600 border-white hover:border-primary-500' }}
                ">
                Merchant Referrers
            </button>
        </div>

        {{-- Table --}}
        <div class="overflow-auto py-5 px-4 bg-white rounded-2xl">
            <x-table.standard>
                <x-slot:table_header>
                    <x-table.standard.th class="!px-2 !py-0 !pb-3">
                        Referrer
                    </x-table.standard.th>
                    <x-table.standard.th class="!px-2 !py-0 !pb-3">
                        Referral Code
                    </x-table.standard.th>
                    <x-table.standard.th class="!px-2 !py-0 !pb-3">
                        <div class="flex flex-row items-center">
                            <span>Invitations Sent</span>
                            <button wire:click="sortTable('invites_sent')">
                                <x-icon.sort />
                            </button>
                        </div>
                    </x-table.standard.th>
                    <x-table.standard.th class="!px-2 !py-0 !pb-3">
                        <div class="flex flex-row items-center">
                            <span>Standard Referrals</span>
                            <button wire:click="sortTable('standard_referrals_total')">
                                <x-icon.sort />
                            </button>
                        </div>
                    </x-table.standard.th>
                    <x-table.standard.th class="!px-2 !py-0 !pb-3">
                        <div class="flex flex-row items-center">
                            <span>Merchant Referrals</span>
                            <button wire:click="sortTable('merchant_referrals_total')">
                                <x-icon.sort />
                            </button>
                        </div>
                    </x-table.standard.th>
                    <x-table.standard.th class="!px-2 !py-0 !pb-3">
                        <div class="flex flex-row items-center">
                            <span>Incentives Received</span>
                            <button wire:click="sortTable('incentives_received')">
                                <x-icon.sort />
                            </button>
                        </div>
                    </x-table.standard.th>
                </x-slot:table_header>
                <x-slot:table_data>
                    @if ($this->referrers)
                        @forelse ($this->referrers as $key => $referrer)
                            <x-table.standard.row 
                                @click="applySlideInAnimation()"
                                wire:key="{{ $tab . '-' . $referrer->id }}" 
                                wire:click="openReferrerDetails({{ $referrer->id }})" class="cursor-pointer hover:bg-rp-neutral-100">
                                <x-table.standard.td class="min-w-52">
                                    <div class="flex flex-row items-center gap-4">
                                        <div
                                            class="w-8 h-8 max-w-8 max-h-8 min-w-8 min-h-8 rounded-full overflow-hidden">
                                            @if (isset($referrer->logo_url))
                                                <img src="{{ $referrer->logo_url }}"
                                                    alt="{{ $referrer->name }}'s profile image"
                                                    class="w-full h-full object-cover rounded-full">
                                            @else
                                                <img src="{{ url('images/user/default-avatar.png') }}" alt=""
                                                    class="w-full h-full object-cover rounded-full">
                                            @endif
                                        </div>
                                        <div>{{ $referrer->name }}</div>
                                    </div>
                                </x-table.standard.td>
                                <x-table.standard.td class="w-48 min-w-48 max-w-48">
                                    {{ $referrer->referral_code }}
                                </x-table.standard.td>
                                <x-table.standard.td class="w-52 min-w-52 max-w-52">
                                    {{ number_format($referrer->invites_sent) }}
                                </x-table.standard.td>
                                <x-table.standard.td class="w-60 min-w-60 max-w-60">
                                    <div class="flex flex-col">
                                        <div>{{ number_format($referrer->standard_referrals_pending) }} pending</div>
                                        <div>{{ number_format($referrer->standard_referrals_verified) }} successful
                                        </div>
                                    </div>
                                </x-table.standard.td>
                                <x-table.standard.td class="w-60 min-w-60 max-w-60">
                                    <div class="flex flex-col">
                                        <div>{{ number_format($referrer->merchant_referrals_pending) }} pending</div>
                                        <div>{{ number_format($referrer->merchant_referrals_verified) }} successful
                                        </div>
                                    </div>
                                </x-table.standard.td>
                                <x-table.standard.td class="w-60 min-w-60 max-w-60 text-rp-green-600 font-bold">
                                    {{ Number::currency($referrer->incentives_received, 'PHP') }}
                                </x-table.standard.td>
                            </x-table.standard.row>
                        @empty
                            <x-table.standard.row>
                                <x-table.standard.td colspan="6">
                                    No data available
                                </x-table.standard.td>
                            </x-table.standard.row>
                        @endforelse
                    @else
                        <x-table.standard.row>
                            <x-table.standard.td colspan="6">
                                No data available
                            </x-table.standard.td>
                        </x-table.standard.row>
                    @endif
                </x-slot:table_data>
            </x-table.standard>
        </div>

        {{-- Pagination --}}
        @if ($this->referrers)
            <div class="flex items-center justify-center w-full gap-8">
                {{ $this->referrers->links('pagination.custom-pagination') }}
            </div>
        @endif
    </div>

    <div x-cloak x-show="$wire.selected_referrer_id !== null" class="fixed inset-0 bg-black bg-opacity-30">
        <div class="w-[647px] h-full bg-white absolute overflow-y-auto"
            :class="{ 
                'referrer-details-with-slide-in-animation' : animation === 'slide-in', 
                'referrer-details-with-slide-out-animation' : animation === 'slide-out'
            }"  
            @click.outside="(e) => {
                if (e.target.closest('.flatpickr-calendar')) {
                    return;
                }
                applySlideOutAnimation();
                $wire.closeReferrerDetails();
            }">
            <livewire:admin.referrals.referrers.referrer-details :referrer_id="$selected_referrer_id" :$start_date :$end_date :$tab wire:key="{{ $tab . '-' . $selected_referrer_id . $start_date->format('Y-m-d') }}" lazy />
        </div>
    </div>

    <x-loader.black-screen wire:loading.delay class="z-10">
        <x-loader.clock />
    </x-loader.black-screen>
</x-main.content>


@script
    <script>
        Alpine.data('referrer_details_ui', () => {
            return {
                animation: '',

                applySlideInAnimation() {
                    this.animation = 'slide-in';
                },

                applySlideOutAnimation () {
                    this.animation = 'slide-out';
                }
            }
        });
    </script>
@endscript

@push('styles')
    <style>
        .referrer-details-with-slide-in-animation {
            animation: referrer-details-hide-slide-in-animation 1s forwards;
        }

        .referrer-details-with-slide-out-animation {
            animation: referrer-details-hide-slide-out-animation 1s forwards;
        }

        @keyframes referrer-details-hide-slide-in-animation {
            from {
                right: -647px;
            }
            to {
                right: 0px;
            }
        }
        
        @keyframes referrer-details-hide-slide-out-animation {
            from {
                right: 0px;
            }
            to {
                right: -647px;
            }
        }
    </style>
@endpush
