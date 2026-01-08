<div class="flex h-full" x-data="{ selectedTab: @entangle('selectedTab'), secondaryTab: '' }">
    @vite(['resources/js/flatpickr.js'])
    <x-main.content class="grow !px-16 !py-10">
        <x-main.action-header>
            <x-slot:title>Fee Management</x-slot:title>
        </x-main.action-header>
        <div class="navigation w-full">
            <div class="w-full flex mb-5">
                <div class="navigation-buttons w-full flex border-b border-rp-neutral-300">
                    @foreach ($allowedTabs as $tab)
                        <button @click="selectedTab = '{{ $tab }}' "
                            x-bind:class="selectedTab === '{{ $tab }}' ?
                                'border-b-2 border-primary-700 text-primary-700 font-bold' :
                                'hover:border-b-2 hover:border-primary-700 hover:text-primary-700 text-rp-neutral-700'"
                            class="w-44 py-2.5">
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

                {{--
                            Todo: Add date filtering for upcoming components (Audit Trail - Change history & KPIs)
                    --}}
                <div class="date-filter relative text-nowrap" x-cloak x-show="selectedTab === 'KPIs'">
                    <div class="flex flex-col xl:flex-row xl:items-center gap-2.5">
                        <div>Filter by:</div>
                        <div class="kpi_date_filter " x-data="referral_system({ appendTo: document.querySelector('.kpi_date_filter') })">
                            <div class="absolute top-1/2 translate-x-1/3 -translate-y-1/2">
                                <x-icon.calendar-outline />
                            </div>
                            <input type="text" x-ref="month_filter" {{ 'disabled' }}
                                class="w-full xl:w-max pl-9 rounded-lg border text-left focus:outline-none border-neutral-300 focus:!border-neutral-300 focus:ring-2 focus:ring-primary-500 focus:ring-offset-white focus:ring-offset-2 transition-all duration-200 p-2 h-full" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="posts" x-cloak x-show="selectedTab === 'manage-fees'">
                <livewire:admin.fee-management.manage-fees />
            </div>
            <div class="posts" x-cloak x-show="selectedTab === 'audit-trail'">Audit Trail Tabx</div>
            <div class="posts" x-cloak x-show="selectedTab === 'KPIs'">KPIs Tab</div>
        </div>
    </x-main.content>

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
