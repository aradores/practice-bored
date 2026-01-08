<div class="w-full flex flex-col gap-9" x-data="modals">
    <div class="flex flex-col gap-3 pb-5 border-b border-[#BBC5CD]">
        <h2 class="text-primary-600 font-bold text-xl">Control</h2>
        <div class="flex flex-row items-center w-full">
            <div class="w-[260px] xl:w-[389px]">
                Standard Referrals
            </div>
            <label class="switch mr-5">
                <input wire:model.live="toggle_standard_referrals" type="checkbox">
                <span class="slider round"></span>
            </label>
            @if ($this->user_referral_season)
                @if ($this->user_referral_season?->end_date)
                    <div class="py-2 px-4 bg-white border border-neutral-500 rounded-lg flex flex-row items-center gap-2"
                        x-data="{ showDeadlineMenu: false }">
                        <div><x-icon.calendar-outline /></div>
                        <div class="w-[132px]">{{ $this->user_referral_season->end_date->format('F Y') }}</div>
                        <div class="relative" x-data="{ showDeadlineMenu: false }">
                            <button type="button" class="flex justify-self-center"
                                @click="showDeadlineMenu=true"><x-icon.kebab-menu /></button>
                            <x-dropdown.dropdown-list x-cloak x-show="showDeadlineMenu"
                                @click.away="showDeadlineMenu=false;"
                                class="z-10 absolute top-[100%] -right-28 rounded-md border w-36">
                                <x-dropdown.dropdown-list.item wire:click="showAddDeadlineModal('standard')">
                                    Edit
                                </x-dropdown.dropdown-list.item>
                                <x-dropdown.dropdown-list.item wire:click="showRemoveDeadlineModal('standard')">
                                    Clear Deadline
                                </x-dropdown.dropdown-list.item>
                            </x-dropdown.dropdown-list>
                        </div>
                    </div>
                @else
                    <div class="flex flex-row items-center gap-1">
                        <div>No deadline yet</div>
                        <button wire:click="showAddDeadlineModal('standard')">
                            <x-icon.add />
                        </button>
                    </div>
                @endif
            @endif
        </div>
        <div class="flex flex-row items-center w-full">
            <div class="w-[260px] xl:w-[389px]">
                Merchant Referrals
            </div>
            <label class="switch mr-5">
                <input wire:model.live="toggle_merchant_referrals" type="checkbox">
                <span class="slider round"></span>
            </label>
            @if ($this->merchant_referral_season)
                @if ($this->merchant_referral_season?->end_date)
                    <div class="py-2 px-4 bg-white border border-neutral-500 rounded-lg flex flex-row items-center gap-2"
                        x-data="{ showDeadlineMenu: false }">
                        <div><x-icon.calendar-outline /></div>
                        <div class="w-[132px]">{{ $this->merchant_referral_season->end_date->format('F Y') }}</div>
                        <div class="relative" x-data="{ showDeadlineMenu: false }">
                            <button type="button" class="flex justify-self-center"
                                @click="showDeadlineMenu=true"><x-icon.kebab-menu /></button>
                            <x-dropdown.dropdown-list x-cloak x-show="showDeadlineMenu"
                                @click.away="showDeadlineMenu=false;"
                                class="z-10 absolute top-[100%] -right-28 rounded-md border w-36">
                                <x-dropdown.dropdown-list.item wire:click="showAddDeadlineModal('merchant')">
                                    Edit
                                </x-dropdown.dropdown-list.item>
                                <x-dropdown.dropdown-list.item wire:click="showRemoveDeadlineModal('merchant')">
                                    Clear Deadline
                                </x-dropdown.dropdown-list.item>
                            </x-dropdown.dropdown-list>
                        </div>
                    </div>
                @else
                    <div class="flex flex-row items-center gap-1">
                        <div>No deadline yet</div>
                        <button wire:click="showAddDeadlineModal('merchant')">
                            <x-icon.add />
                        </button>
                    </div>
                @endif
            @endif
        </div>
    </div>
    <div class="flex flex-col gap-3 pb-5 border-b border-[#BBC5CD]">
        <h2 class="text-primary-600 font-bold text-xl">Incentive Settings</h2>
        <div class="h-10 flex flex-row items-center w-full">
            <div class="w-[260px] xl:w-[389px]">
                Standard Referrals (1 set)
            </div>
            <div x-cloak x-show="$wire.show_standard_incentive_edit == true">
                <div class="flex flex-col">
                    <div class="flex flex-row items-center gap-1">
                        <x-input.input wire:model.live="standard_incentive_amount" type="number" placeholder="500.00"
                            class="w-[120px] py-2 px-1 text-rp-neutral-700 text-sm rounded-lg border border-rp-neutral-500 bg-white" />
                        <x-button.outline-button color="primary" class="!p-2.5 !rounded-[4px] !text-xs"
                            @click="$wire.show_standard_incentive_edit=false;">
                            cancel
                        </x-button.outline-button>
                        <x-button.filled-button color="primary" class="!p-2.5 !rounded-[4px] !text-xs"
                            wire:click="showConfirmEditStandardIncentiveModal">
                            confirm
                        </x-button.filled-button>
                    </div>
                    @error('standard_incentive_amount')
                        <p class="text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div x-cloak x-show="$wire.show_standard_incentive_edit == false">
                <div class="flex flex-row gap-1">
                    <div class="text-rp-neutral-600 font-bold">
                        {{ Number::currency($this->standard_incentive, 'PHP') }}
                    </div>
                    <button type="button" @click="$wire.show_standard_incentive_edit=true">
                        <x-icon.edit />
                    </button>
                </div>
            </div>
        </div>
        <div class="h-10 flex flex-row items-center w-full">
            <div class="w-[260px] xl:w-[389px]">
                Merchant Referrals
            </div>
            <div x-cloak x-show="$wire.show_merchant_incentive_edit == true">
                <div class="flex flex-col">
                    <div class="flex flex-row items-center gap-1">
                        <x-input.input wire:model.live="merchant_incentive_amount" type="number" placeholder="500.00"
                            class="w-[120px] py-2 px-1 text-rp-neutral-700 text-sm rounded-lg border border-rp-neutral-500 bg-white" />
                        <x-button.outline-button color="primary" class="!p-2.5 !rounded-[4px] !text-xs"
                            @click="$wire.show_merchant_incentive_edit=false;">
                            cancel
                        </x-button.outline-button>
                        <x-button.filled-button color="primary" class="!p-2.5 !rounded-[4px] !text-xs"
                            wire:click="showConfirmEditMerchantIncentiveModal">
                            confirm
                        </x-button.filled-button>
                    </div>
                    @error('merchant_incentive_amount')
                        <p class="text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div x-cloak x-show="$wire.show_merchant_incentive_edit == false">
                <div class="flex flex-row gap-1">
                    <div class="text-rp-neutral-600 font-bold">
                        {{ Number::currency($this->merchant_incentive, 'PHP') }}
                    </div>
                    <button type="button" @click="$wire.show_merchant_incentive_edit=true">
                        <x-icon.edit />
                    </button>
                </div>
            </div>
        </div>
    </div>
    <template x-teleport="body">
        <x-modal x-model="showModal">
            <template x-if="$wire.show_start_standard_referral_season_modal">
                <x-modal.form-modal title="Toggle Standard Referrals" :showCloseButton="false" class="!gap-2 !w-[447px] !p-6">
                    <div class="mb-8">
                        <p class="text-center text-rp-neutral-700 mb-3">
                            This will turn on the entire Standard Referral program, and any referral activity will
                            be
                            allowed until you turn it off again. Optionally, you can choose an end month for it to
                            be
                            turned
                            off.
                        </p>
                        <x-input.input-group>
                            <x-slot:label>Choose month</x-slot:label>
                            <x-input type="month" wire:model="month" />
                            <div class="flex justify-end text-tp-neutral-600 text-xs">
                                You can leave this blank!
                            </div>
                            @error('month')
                                <p class="text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </x-input.input-group>
                    </div>
                    <x-slot:action_buttons>
                        <x-button.outline-button color="primary" class="grow"
                            @click="$wire.dispatch('cancelModal')">
                            go back
                        </x-button.outline-button>
                        <x-button.filled-button color="primary" class="grow" wire:click="startStandardReferrals">
                            confirm
                        </x-button.filled-button>
                    </x-slot:action_buttons>
                </x-modal.form-modal>
            </template>

            <template x-if="$wire.show_start_merchant_referral_season_modal">
                <x-modal.form-modal title="Toggle Merchant Referrals" :showCloseButton="false"
                    class="!gap-2 !w-[447px] !p-6">
                    <div class="mb-8">
                        <p class="text-center text-rp-neutral-700 mb-3">
                            This will turn on the entire Merchant Referral program, and any referral activity will
                            be
                            allowed until you turn it off again. Optionally, you can choose an end month for it to
                            be
                            turned off.
                        </p>
                        <x-input.input-group>
                            <x-slot:label>Choose month</x-slot:label>
                            <x-input type="month" wire:model="month" />
                            <div class="flex justify-end text-rp-neutral-600 text-xs">
                                You can leave this blank!
                            </div>
                            @error('month')
                                <p class="text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </x-input.input-group>
                    </div>
                    <x-slot:action_buttons>
                        <x-button.outline-button color="primary" class="grow"
                            @click="$wire.dispatch('cancelModal')">
                            go back
                        </x-button.outline-button>
                        <x-button.filled-button color="primary" class="grow" wire:click="startMerchantReferrals">
                            confirm
                        </x-button.filled-button>
                    </x-slot:action_buttons>
                </x-modal.form-modal>
            </template>

            <template x-if="$wire.show_end_standard_referral_season_modal">
                <x-modal.form-modal title="Toggle Standard Referrals" :showCloseButton="false"
                    class="!gap-2 !w-[447px] !p-6">
                    <div class="mb-8">
                        <p class="text-center text-rp-neutral-700 mb-3">
                            This will turn off the entire Standard Referral program, and any referral activity will
                            halt. This means users will not be able to refer standard users to the platform anymore.
                            You
                            can always reactivate this again anytime. Are you sure you want to turn it off?
                        </p>
                    </div>
                    <x-slot:action_buttons>
                        <x-button.outline-button color="primary" class="grow"
                            @click="$wire.dispatch('cancelModal')">
                            go back
                        </x-button.outline-button>
                        <x-button.filled-button color="primary" class="grow" wire:click="endStandardReferrals">
                            confirm
                        </x-button.filled-button>
                    </x-slot:action_buttons>
                </x-modal.form-modal>
            </template>

            <template x-if="$wire.show_end_merchant_referral_season_modal">
                <x-modal.form-modal title="Toggle Merchant Referrals" :showCloseButton="false"
                    class="!gap-2 !w-[447px] !p-6">
                    <div class="mb-8">
                        <p class="text-center text-rp-neutral-700 mb-3">
                            This will turn off the entire Merchant Referral program, and any referral activity will
                            halt. This means users will not be able to refer merchants to the platform anymore. You
                            can
                            always reactivate this again anytime. Are you sure you want to turn it off?
                        </p>
                    </div>
                    <x-slot:action_buttons>
                        <x-button.outline-button color="primary" class="grow"
                            @click="$wire.dispatch('cancelModal')">
                            go back
                        </x-button.outline-button>
                        <x-button.filled-button color="primary" class="grow" wire:click="endMerchantReferrals">
                            confirm
                        </x-button.filled-button>
                    </x-slot:action_buttons>
                </x-modal.form-modal>
            </template>

            <template x-if="$wire.show_referral_deadline_modal">
                <x-modal.form-modal :title="$deadline_modal_title" :showCloseButton="false" class="!gap-2 !w-[447px] !p-6">
                    <div class="mb-8">
                        <p class="text-center text-rp-neutral-700 mb-3">
                            @if ($deadline_modal_title == 'Add Deadline')
                                Add a deadline for this program so that it automatically turns off at the specified
                                month.
                            @else
                                Edit the deadline for this program by specifying the month below.
                            @endif
                        </p>
                        <x-input.input-group>
                            <x-slot:label>Choose month</x-slot:label>
                            <x-input type="month" wire:model.live="month" />
                            <div class="flex justify-end text-rp-neutral-600 text-xs">
                                You can leave this blank!
                            </div>
                            @error('month')
                                <p class="text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </x-input.input-group>
                    </div>
                    <x-slot:action_buttons>
                        <x-button.outline-button color="primary" class="grow"
                            @click="$wire.dispatch('closeModal')">
                            go back
                        </x-button.outline-button>
                        <x-button.filled-button color="primary" class="grow" wire:click="addDeadlineToReferral">
                            confirm
                        </x-button.filled-button>
                    </x-slot:action_buttons>
                </x-modal.form-modal>
            </template>

            <template x-if="$wire.show_remove_referral_deadline_modal">
                <x-modal.form-modal title="Remove Deadline" :showCloseButton="false" class="!gap-2 !w-[447px] !p-6">
                    <div class="mb-8">
                        <p class="text-center text-rp-neutral-700 mb-3">
                            Are you sure you want to remove the deadline of this program?
                        </p>
                    </div>
                    <x-slot:action_buttons>
                        <x-button.outline-button color="primary" class="grow"
                            @click="$wire.dispatch('closeModal')">
                            go back
                        </x-button.outline-button>
                        <x-button.filled-button color="primary" class="grow"
                            wire:click="removeDeadlineFromReferral">
                            confirm
                        </x-button.filled-button>
                    </x-slot:action_buttons>
                </x-modal.form-modal>
            </template>

            <template x-if="$wire.show_confirm_edit_standard_incentive_amount">
                <x-modal.form-modal title="Confirm Amount" :showCloseButton="false" class="!gap-2 !w-[447px] !p-6">
                    <div class="mb-8">
                        <p class="text-center text-rp-neutral-700 mb-3">
                            This will change the amount for the entire program. Are you sure you want to continue?
                        </p>
                    </div>
                    <x-slot:action_buttons>
                        <x-button.outline-button color="primary" class="grow"
                            @click="$wire.dispatch('closeModal')">
                            go back
                        </x-button.outline-button>
                        <x-button.filled-button color="primary" class="grow"
                            wire:click="editStandardReferralIncentive">
                            confirm
                        </x-button.filled-button>
                    </x-slot:action_buttons>
                </x-modal.form-modal>
            </template>

            <template x-if="$wire.show_confirm_edit_merchant_incentive_amount">
                <x-modal.form-modal title="Confirm Amount" :showCloseButton="false" class="!gap-2 !w-[447px] !p-6">
                    <div class="mb-8">
                        <p class="text-center text-rp-neutral-700 mb-3">
                            This will change the amount for the entire program. Are you sure you want to continue?
                        </p>
                    </div>
                    <x-slot:action_buttons>
                        <x-button.outline-button color="primary" class="grow"
                            @click="$wire.dispatch('closeModal')">
                            go back
                        </x-button.outline-button>
                        <x-button.filled-button color="primary" class="grow"
                            wire:click="editMerchantReferralIncentive">
                            confirm
                        </x-button.filled-button>
                    </x-slot:action_buttons>
                </x-modal.form-modal>
            </template>
        </x-modal>
    </template>
</div>


@script
    <script>
        Alpine.data('modals', () => ({
            showModal: false,

            init() {
                this.$wire.on('openModal', () => {
                    this.showModal = true;
                });

                this.$wire.on('closeModal', () => {
                    this.showModal = false;
                });
            }
        }));
    </script>
@endscript

@push('styles')
    <style>
        /* The switch - the box around the slider */
        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 30px;
        }

        /* Hide default HTML checkbox */
        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        /* The slider */
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #647887;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 35px;
            width: 35px;
            left: -5px;
            bottom: -2.5px;
            background-color: white;
            border: 2px solid #647887;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked+.slider {
            background-color: #6848AD;
        }

        input:focus+.slider {
            box-shadow: 0 0 1px #6848AD;
        }

        input:checked+.slider:before {
            -webkit-transform: translateX(35px);
            -ms-transform: translateX(35px);
            transform: translateX(35px);
            border: 2px solid #6848AD;
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }
    </style>
@endpush
