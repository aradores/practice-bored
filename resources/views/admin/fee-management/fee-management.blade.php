<div class="flex h-full w-full flex-col" x-data="{ 
    selectedTab: @entangle('selectedTab'), 
    auditTrailTab: 'change-history' }">
    <x-main.content class="grow !px-4 md:!px-8 lg:!px-16 !py-6 md:!py-10">
        <x-main.action-header>
            <x-slot:title>Fee Management</x-slot:title>
        </x-main.action-header>

        <div class="navigation w-full">
            <div class="w-full flex flex-wrap xl:flex-nowrap mb-4 md:mb-5 gap-3 md:gap-0">
                <div class="navigation-buttons flex overflow-x-auto md:overflow-visible border-b border-rp-neutral-300 w-full">
                    @foreach ($allowedTabs as $tab)
                        <button @click="selectedTab = '{{ $tab }}'"
                            x-bind:class="selectedTab === '{{ $tab }}'
                                ? 'border-b-2 border-primary-700 text-primary-700 font-bold'
                                : 'hover:border-b-2 hover:border-primary-700 hover:text-primary-700 text-rp-neutral-700'"
                            class="whitespace-nowrap px-3 sm:px-4 lg:w-44 py-2.5 flex-shrink-0 text-sm sm:text-base">
                            @switch($tab)
                                @case('manage-fees')
                                    Manage Fees
                                    @break
                                @case('audit-trail')
                                    Audit Trail
                                    @break
                                @default
                                    {{ $tab }}
                            @endswitch
                        </button>
                    @endforeach
                </div>

                <div class="date-filter relative text-nowrap mt-3 xl:mt-0 xl:ml-auto"
                    x-cloak x-show="selectedTab === 'KPIs' || auditTrailTab === 'change-history' && selectedTab === 'audit-trail' ">
                    <div class="flex flex-col sm:flex-row sm:items-center gap-2.5">
                        <div class="text-sm sm:text-base">Filter by:</div>
                        <x-date-picker.date-range-picker
                            id="fee-management"
                            :from='null'
                            :to='null'
                            :maxDateToday="false"
                            placeholder="Select a date range"
                            class="w-1/3"
                        />

                        {{-- <x-button.primary-gradient-button size="sm" class="px-3" @click="$dispatch('clear-date-range-fee-management')">
                            <span>
                                <x-icon.reset width="22" height="22" />
                            </span>
                        </x-button.primary-gradient-button> --}}
                    </div>
                </div>
            </div>
        </div>

        <div class="content w-full">
            <template x-if="selectedTab === 'manage-fees'">
                <livewire:admin.fee-management.manage-fees wire:key="fee-management-component" />
            </template>

            <template x-if="selectedTab === 'audit-trail'">
                <livewire:admin.fee-management.audit-trails wire:key="audit-trail-component" />
            </template>

            <template x-if="selectedTab === 'KPIs'">
                <livewire:admin.fee-management.kpi wire:key="kpi-component" />
            </template>
        </div>
    </x-main.content>
    <div class="spacer my-2 w-full"></div>
</div>