<div class="p-6 rounded-1 border border-primary-700 bg-primary-100 flex flex-col 2xl:flex-row gap-6 relative"
    x-data="balanceModals">
    <div
        class="flex flex-col {{ $this->available_balance >= $this->pending_reward_withdrawals ? 'text-primary-600' : 'text-rp-red-600' }}">
        <div class="flex flex-row items-center gap-1 text-[19.2px] leading-normal">
            <div x-data="tooltip" class="relative cursor-pointer" @mouseover="open" @mouseleave="close">
                <div>
                    <x-icon.info />
                </div>
                {{-- Tooltip --}}
                <div x-cloak x-show="isOpen"
                    class="absolute w-72 max-w-72 bottom-[125%] left-[-50%]  rounded-md px-2 py-1 bg-rp-neutral-700 text-white font-light text-xs">
                    <span>Funds available for immediate referral reward payout</span>
                    <div
                        class="absolute top-full left-4 -translate-x-1/2 w-0 h-0 
                        border-l-8 border-l-transparent 
                        border-r-8 border-r-transparent 
                        border-t-8 border-rp-neutral-700">
                    </div>
                </div>
            </div>
            <div>Available Balance</div>
        </div>
        <div class="text-[32px] font-bold leading-7">{{ Number::currency($this->available_balance, 'PHP') }}</div>
    </div>
    <div class="flex flex-col text-rp-yellow-600">
        <div class="flex flex-row items-center gap-1 text-[19.2px] leading-normal">
            <div x-data="tooltip" class="relative cursor-pointer" @mouseover="open" @mouseleave="close">
                <div>
                    <x-icon.info />
                </div>
                {{-- Tooltip --}}
                <div x-cloak x-show="isOpen"
                    class="absolute w-72 max-w-72 bottom-[125%] left-[-50%]  rounded-md px-2 py-1 bg-rp-neutral-700 text-white font-light text-xs">
                    <span>Total reward amounts requested but not yet released</span>
                    <div
                        class="absolute top-full left-4 -translate-x-1/2 w-0 h-0 
                        border-l-8 border-l-transparent 
                        border-r-8 border-r-transparent 
                        border-t-8 border-rp-neutral-700">
                    </div>
                </div>
            </div>
            <div>Pending Reward Withdrawals</div>
        </div>
        <div class="text-[32px] font-bold leading-7">{{ Number::currency($this->pending_reward_withdrawals, 'PHP') }}
        </div>
    </div>
    <div class="flex flex-col text-rp-green-600">
        <div class="flex flex-row items-center gap-1 text-[19.2px] leading-normal">
            <div x-data="tooltip" class="relative cursor-pointer" @mouseover="open" @mouseleave="close">
                <div>
                    <x-icon.info />
                </div>
                {{-- Tooltip --}}
                <div x-cloak x-show="isOpen"
                    class="absolute w-72 max-w-72 bottom-[125%] left-[-50%] rounded-md px-2 py-1 bg-rp-neutral-700 text-white font-light text-xs">
                    <span>Total referral rewards successfully paid out to users</span>
                    <div
                        class="absolute top-full left-4 -translate-x-1/2 w-0 h-0 
                        border-l-8 border-l-transparent 
                        border-r-8 border-r-transparent 
                        border-t-8 border-rp-neutral-700">
                    </div>
                </div>
            </div>
            <div>Total Rewards Distributed</div>
        </div>
        <div class="text-[32px] font-bold leading-7">{{ Number::currency($this->total_reward_distributed, 'PHP') }}
        </div>
    </div>

    {{-- Send Reward --}}
    <x-button.filled-button color="primary" :disabled="!$this->button_clickable" @click="isReleaseModalVisible=true"
        class="px-4 py-2 h-fit self-start 2xl:self-end flex flex-row items-center leading-none gap-3 shadow-small-dark">
        <div>Send Reward</div>
        <div><x-icon.hand-cash /></div>
    </x-button.filled-button>

    <div class="absolute right-[-10%] xl:right-0 top-[-4px] 2xl:top-[-49%]">
        <img src="{{ asset('images/icon/megaphone.png') }}" alt="" class="h-[336px] 2xl:h-[156px]">
    </div>


    <template x-teleport="body">
        <x-modal x-model="isReleaseModalVisible">
            <div class="space-y-4 bg-white rounded-3xl w-[761px] p-8 flex flex-col justify-center items-center gap-3">
                <img src="{{ asset('images/icon/money-cup-full.png') }}" alt="">
                <h3 class="text-2xl font-bold text-rp-neutral-700 text-center leading-none">Ready to Distribute Rewards</h3>
                <p class="text-center text-pretty">You have enough funds to distribute the referral rewards. Would you like to proceed now?</p>
                <div class="w-full flex flex-row gap-4">
                    <x-button.outline-button color="primary" @click="isReleaseModalVisible=false" class="w-1/2">Cancel</x-button.outline-button>
                    <x-button.filled-button color="primary" wire:click="sendReward" class="w-1/2">Proceed</x-button.filled-button>
                </div>
            </div>
        </x-modal>
    </template>

    <template x-teleport="body">
        <x-modal x-model="isInsufficientFundsModalVisible">
            <div class="space-y-4 bg-white rounded-3xl w-[761px] p-8 flex flex-col justify-center items-center gap-3">
                <img src="{{ asset('images/icon/money-cup-empty.png') }}" alt="">
                <h3 class="text-2xl font-bold text-rp-neutral-700 text-center leading-none">Insufficient Balance to Distribute Referral Reward</h3>
                <p class="text-center text-pretty">You currently don’t have enough balance to proceed with distributing referral rewards. Please add funds now.</p>
                <div class="w-full flex flex-row gap-4" wire:ignore>
                    <x-button.outline-button color="primary" @click="isInsufficientFundsModalVisible=false" class="w-1/2">Cancel</x-button.outline-button>
                    @if (request()->routeIs('admin.referrals.index'))
                        <x-button.filled-button color="primary" @click="isInsufficientFundsModalVisible=false" class="w-1/2">Go to Referral Page</x-button.filled-button>   
                    @else
                        <x-button.filled-button color="primary" href="{{ route('admin.referrals.index') }}" class="w-1/2">Go to Referral Page</x-button.filled-button>
                    @endif
                </div>
            </div>
        </x-modal>
    </template>
</div>

@script
    <script>
        Alpine.data('balanceModals', () => ({
            isReleaseModalVisible: $wire.entangle('isReleaseModalVisible'),
            isInsufficientFundsModalVisible: $wire.entangle('isInsufficientFundsModalVisible'),

        }));

        Alpine.data('tooltip', () => ({
            isOpen: false,
            open() {
                this.isOpen = true;
            },
            close() {
                this.isOpen = false;
            },
        }));
    </script>
@endscript
