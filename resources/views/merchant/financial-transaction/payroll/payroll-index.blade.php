<div class="w-full h-full flex flex-row" x-data="payrollIndex">
    <div
        class="py-10 px-4 min-w-[calc(100%-511px)] w-full {{ isset($view_payroll_id) ? 'border-r border-rp-neutral-100' : '' }}">
        <div class="flex flex-row items-center justify-between">
            <h1 class="font-bold text-rp-neutral-700 text-2xl">Payroll</h1>
            <div class="flex flex-row items-center gap-2.5">
                {{-- Send Salary button --}}
                <div id="send-salary-card" class="flex flex-row items-stretch" x-data="{ show_send_salary_dropdown: false }">
                    <a href="{{ route('merchant.financial-transactions.payroll.create', ['merchant' => $merchant]) }}"
                        class="flex items-center rounded-tl-lg rounded-bl-lg bg-rp-red-500 hover:bg-rp-red-600 text-white text-sm font-bold uppercase p-2.5 border-r border-white"
                        :class="{ 'bg-rp-red-600': show_send_salary_dropdown }">
                        Send Salary
                    </a>
                    <div class="relative flex items-stretch" @click.away="show_send_salary_dropdown=false">
                        <button @click="show_send_salary_dropdown=!show_send_salary_dropdown"
                            class="flex items-center rounded-tr-lg rounded-br-lg bg-rp-red-500 hover:bg-rp-red-600 text-white p-2.5 border-r border-white"
                            :class="{ 'bg-rp-red-600': show_send_salary_dropdown }">
                            <x-icon.triangle-down width="16" height="16" color="#ffffff" />
                        </button>
                        <div x-cloak x-show="show_send_salary_dropdown"
                            class="absolute mt-1 top-10 right-0 z-10 shadow-md bg-white rounded-lg flex flex-col w-72 text-sm">
                            <a href="{{ route('merchant.financial-transactions.payroll.create', ['merchant' => $merchant]) }}"
                                class="p-3 text-rp-neutral-500 hover:bg-rp-neutral-100">Send manually</a>
                            <a href="{{ route('merchant.financial-transactions.payroll.bulk-upload', ['merchant' => $merchant]) }}"
                                class="p-3 text-rp-neutral-500 hover:bg-rp-neutral-100">Send in bulk</a>
                        </div>
                    </div>
                </div>

                {{-- Export button --}}
                <div id="export-card" class="relative">
                    <x-button.outline-icon-button title="Export" icon="icon.send-square" color="rp-red"
                        @click="show_export_form=!show_export_form" />
                    <div x-cloak x-show="show_export_form" class="absolute mt-1 right-0 z-10">
                        <livewire:merchant.financial-transaction.payroll.payroll-export :$merchant />
                    </div>
                </div>

                {{-- Activity history button --}}
                <div id="activity-history-card" class="relative">
                    <x-button.outline-icon-button title="Activity History" left_icon="icon.clock"
                        icon="icon.solid-arrow-right" color="rp-red"
                        @click="$wire.set('show_activity_history_modal', true)" />
                </div>

            </div>
        </div>

        <x-card.overall-stats title="Available Balance" :current_amount="$this->available_balance" class="my-5" />

        {{-- Tabs --}}
        <div class="flex border-b border-rp-neutral-100 mb-5">
            <div class="flex justify-between items-center gap-2">
                <button wire:click="$set('status', 'pending')"
                    class="w-36 py-2.5 text-sm {{ $this->status === 'pending' ? 'border-b-2 border-primary-700 text-primary-700 font-bold' : 'text-rp-neutral-700' }}">
                    Pending
                </button>
                <button wire:click="$set('status', 'scheduled')"
                    class="w-36 py-2.5 text-sm {{ $this->status === 'scheduled' ? 'border-b-2 border-primary-700 text-primary-700 font-bold' : 'text-rp-neutral-700' }}">
                    Scheduled
                </button>
                <button wire:click="$set('status', 'successful')"
                    class="w-36 py-2.5 text-sm {{ $this->status === 'successful' ? 'border-b-2 border-primary-700 text-primary-700 font-bold' : 'text-rp-neutral-700' }}">
                    Successful
                </button>
                <button wire:click="$set('status', 'rejected')"
                    class="w-36 py-2.5 text-sm {{ $this->status === 'rejected' ? 'border-b-2 border-primary-700 text-primary-700 font-bold' : 'text-rp-neutral-700' }}">
                    Rejected
                </button>
                <button wire:click="$set('status', 'failed')"
                    class="w-36 py-2.5 text-sm {{ $this->status === 'failed' ? 'border-b-2 border-primary-700 text-primary-700 font-bold' : 'text-rp-neutral-700' }}">
                    Failed
                </button>
            </div>
        </div>

        <div class="flex flex-row items-start justify-between mb-5">
            <div class="flex flex-row gap-3">
                {{-- Search --}}
                <x-input.search wire:model.live="search_term" icon_position="left" placeholder="Search Recipient" />

                {{-- Date Range Picker --}}
                <x-date-picker.date-range-picker :from="$from_date" :to="$to_date" id="payroll_index"
                    :maxDateToday="false" />

                {{-- Created By --}}
                <div class="relative" @click.away="show_created_by_dropdown=false">
                    <x-button.dropdown-icon-button icon="user-octagon-outline" title="Created by" width="52"
                        @click="show_created_by_dropdown=true" />
                    <div x-cloak x-show="show_created_by_dropdown">
                        {{-- Created by selection component here --}}
                        <livewire:merchant.financial-transaction.components.requestor-selection :$merchant
                            :$selected_creator_ids event_id="CreatorSelection" />
                    </div>
                </div>

                {{-- Salary Type --}}
                <div class="relative" @click.away="show_salary_type_dropdown=false">
                    <x-button.dropdown-icon-button icon="cash" title="Salary Type" width="52"
                        @click="show_salary_type_dropdown=!show_salary_type_dropdown" />
                    <div x-cloak x-show="show_salary_type_dropdown">
                        <livewire:merchant.financial-transaction.components.salary-type-selection
                            wire:model.live="selected_salary_type_slugs" />
                    </div>
                </div>
            </div>

            @if ($this->status === 'rejected' || $this->status === 'failed')
                <div>
                    <x-button.outline-button wire:click="showDeleteRecordsModal" class="!border !py-2">Delete All
                        Records</x-button.outline-button>
                </div>
            @endif
        </div>

        {{-- Record and page buttons --}}
        <div class="flex flex-row justify-between items-start mb-3">
            <div class="flex flex-row gap-2 items-center">
                <span>Show</span>
                <x-dropdown.select wire:model.live="per_page" class="text-left appearance-none !px-0 !py-0">
                    <x-dropdown.select.option value="10">10</x-dropdown.select.option>
                    <x-dropdown.select.option value="20">20</x-dropdown.select.option>
                    <x-dropdown.select.option value="30">30</x-dropdown.select.option>
                    <x-dropdown.select.option value="40">40</x-dropdown.select.option>
                    <x-dropdown.select.option value="50">50</x-dropdown.select.option>
                </x-dropdown.select>
                <span>records</span>
            </div>
            @if ($this->payrolls->hasPages())
                <div class="flex flex-row gap-2.5">
                    <button wire:click="previousPage"
                        class="p-2 rounded-full {{ $this->payrolls->onFirstPage() ? '' : 'hover:bg-rp-neutral-100' }}"
                        {{ $this->payrolls->onFirstPage() ? 'disabled' : '' }}><x-icon.chevron-left
                            color="{{ $this->payrolls->onFirstPage() ? '#D3DADE' : '#647887' }}" /></button>
                    <button wire:click="nextPage" {{ $this->payrolls->hasMorePages() ? '' : 'disabled' }}
                        class="p-2 rounded-full {{ $this->payrolls->hasMorePages() ? 'hover:bg-rp-neutral-100' : '' }}">
                        <x-icon.chevron-right color="{{ $this->payrolls->hasMorePages() ? '#647887' : '#D3DADE' }}" />
                    </button>
                </div>
            @endif
        </div>

        {{-- Table --}}
        <div id="table_wrapper" class="overflow-auto max-w-full w-full">
            @switch($this->status)
                @case('pending')
                    @include('merchant.financial-transaction.payroll.components.pending-table')
                @break

                @case('scheduled')
                    @include('merchant.financial-transaction.payroll.components.scheduled-table')
                @break

                @case('successful')
                    @include('merchant.financial-transaction.payroll.components.successful-table')
                @break

                @case('rejected')
                    @include('merchant.financial-transaction.payroll.components.rejected-table')
                @break

                @case('failed')
                    @include('merchant.financial-transaction.payroll.components.failed-table')
                @break

                @default
            @endswitch
        </div>

        <div class="flex items-center justify-center w-full gap-8">
            {{ $this->payrolls->links('pagination.standard-pagination') }}
        </div>
    </div>

    @isset($view_payroll_id)
        <div class="p-5">
            <livewire:merchant.financial-transaction.payroll.modals.payroll-request-details :payroll_id="$view_payroll_id" :$merchant
                wire:key="details-modal-{{ $view_payroll_id }}" />
        </div>
    @endisset

    <x-popup x-cloak x-show="selected_payroll_ids.length > 0">
        <template x-if="status === 'pending'">
            <div class="flex flex-row items-center gap-2">
                <div class="font-bold">(<span x-text="`${selected_payroll_ids.length}`"></span> selected)</div>
                <x-button.outline-button @click="clearSelected" class="!border">cancel</x-button.outline-button>
                <x-button.outline-button @click="bulkReject" class="!border">reject selected</x-button.outline-button>
                <x-button.filled-button @click="bulkApprove" class="!border">set for approval</x-button.filled-button>
            </div>
        </template>
        <template x-if="status === 'failed'">
            <div class="flex flex-row items-center gap-2">
                <div class="font-bold">(<span x-text="`${selected_payroll_ids.length}`"></span> selected)</div>
                <x-button.outline-button @click="clearSelected" class="!border">cancel</x-button.outline-button>
                <x-button.filled-button @click="bulkRetry" class="!border">
                    <div class="flex flex-row items-center gap-2">
                        <x-icon.check-no-border />
                        <span>retry failed schedule</span>
                    </div>
                </x-button.filled-button>
            </div>
        </template>
    </x-popup>


    <x-modal x-model="$wire.show_confirmation_modal">
        {{-- Approve form --}}
        @if (isset($payroll_to_approve))
            <livewire:merchant.financial-transaction.payroll.modals.payroll-request-approve-form :payroll_id="$payroll_to_approve"
                wire:key="approve-modal-{{ $payroll_to_approve }}" />
        @endif

        {{-- Reject form --}}
        @if (isset($payroll_to_reject))
            <livewire:merchant.financial-transaction.payroll.modals.payroll-request-reject-form :$merchant
                :payroll_id="$payroll_to_reject" wire:key="reject-modal-{{ $payroll_to_reject }}" />
        @endif

        {{-- Retry Failed form --}}
        @if (isset($payroll_to_retry))
            <livewire:merchant.financial-transaction.payroll.modals.payroll-request-retry-form :$merchant
                :payroll_id="$payroll_to_retry" wire:key="retry-modal-{{ $payroll_to_reject }}" />
        @endif


        {{-- Delete all records --}}
        @if ($show_delete_rejected_modal)
            <livewire:merchant.financial-transaction.payroll.modals.payroll-request-delete-rejected-form :$merchant />
        @endif

        @if ($show_delete_failed_modal)
            <livewire:merchant.financial-transaction.payroll.modals.payroll-request-delete-failed-form :$merchant />
        @endif

    </x-modal>

    <x-modal.side-modal x-model="$wire.show_bulk_action_modal">
        @if (!empty($selected_payroll_ids) && isset($bulk_action))
            <livewire:merchant.financial-transaction.payroll.modals.payroll-bulk-action :$merchant :selected_ids="$selected_payroll_ids"
                :action="$bulk_action" wire:key="bulk-action-{{ $bulk_action }}-{{ implode('-', $selected_payroll_ids) }}" />
        @endif
    </x-modal.side-modal>

    {{-- Activity History --}}
    <x-modal.side-modal x-model="$wire.show_activity_history_modal">
        @if ($show_activity_history_modal)
            <livewire:merchant.financial-transaction.payroll.modals.payroll-activity-history :$merchant />
        @endif
    </x-modal.side-modal>
</div>

@script
    <script>
        Alpine.data('payrollIndex', function() {
            return {
                show_export_form: false,
                show_created_by_dropdown: false,
                show_salary_type_dropdown: false,
                has_selected_all: false,
                selected_payroll_ids: [],
                current_page_payroll_ids: $wire.entangle('current_page_payroll_ids'),
                status: $wire.entangle('status'),

                init() {
                    this.$watch('current_page_payroll_ids', () => {
                        this.has_selected_all = this.validateHasSelectedAllPayrolls();
                    });

                    this.$watch(() => [...this.selected_payroll_ids], () => {
                        this.has_selected_all = this.validateHasSelectedAllPayrolls();
                    });

                    this.$wire.on('setCreatorSelection', () => {
                        this.show_created_by_dropdown = false;
                    });
                    this.$wire.on('closeModalCreatorSelection', () => {
                        this.show_created_by_dropdown = false;
                    });
                    this.$wire.on('closePayrollExportModal', () => {
                        this.show_export_form = false;
                    });
                    this.$wire.on('closeBulkActionComponent', () => {
                        this.show_bulk_action_modal = false;
                        this.selected_payroll_ids = [];
                    });

                    this.$watch('status', () => {
                        this.selected_payroll_ids = [];
                        this.has_selected_all = false;
                    });

                },

                validateHasSelectedAllPayrolls() {
                    return this.current_page_payroll_ids.length > 0 &&
                        this.current_page_payroll_ids.every(id => this.selected_payroll_ids
                            .map(Number)
                            .includes(Number(id)));
                },

                handleSelectAllOnChange(value) {
                    if (value) {
                        this.selected_payroll_ids = [
                            ...new Set([...this.selected_payroll_ids.map(Number),
                                ...this.current_page_payroll_ids
                            ])
                        ];
                        this.has_selected_all = true;
                    } else {
                        this.selected_payroll_ids = this.selected_payroll_ids.filter(
                            id => !this.current_page_payroll_ids.includes(Number(id))
                        );
                        this.has_selected_all = false;
                    }
                },

                clearSelected() {
                    this.selected_payroll_ids = [];
                },

                bulkReject() {
                    this.$wire.show_bulk_action_modal = true;
                    this.$wire.callBulkReject(this.selected_payroll_ids);
                    this.$wire.on('closeModal', () => {
                        this.$wire.show_activity_history_modal = false;
                    });
                },

                bulkRetry() {
                    this.$wire.callBulkRetry(this.selected_payroll_ids);
                    this.$wire.show_bulk_action_modal = true;
                },

                bulkApprove() {
                    this.$wire.callBulkApprove(this.selected_payroll_ids);
                    this.$wire.show_bulk_action_modal = true;
                }


            }
        });
    </script>
@endscript
