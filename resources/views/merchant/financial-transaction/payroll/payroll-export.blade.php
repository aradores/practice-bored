<div class="w-[327px] p-6 bg-white rounded-xl shadow-md" x-data="cashOutflowExport">
    <h2 class="text-rp-neutral-700 font-bold text-xl">Export Data</h2>
    <p class="text-rp-neutral-700">Feel free to set the following filters for the exported data. NOTE: Only Approved
        Transactions will be exported.</p>

    <div class="my-2 flex flex-col gap-2.5 text-rp-neutral-700 text-sm">
        <div class="relative" @click.outside="show_employee_selection = false">
            <x-button.dropdown-icon-button icon="user-octagon-outline" title="All Employees" width="full"
                @click="show_employee_selection=!show_employee_selection" />
            <div x-show="show_employee_selection">
                <livewire:merchant.financial-transaction.components.requestor-selection :$merchant :selected_requestor_ids="$selected_employee_ids"
                    event_id="EmployeeSelection" />
            </div>
        </div>

        <x-date-picker.date-range-picker :$from :$to id="payroll-export" />

        <div class="relative" @click.outside="show_requestor_selection = false">
            <x-button.dropdown-icon-button icon="user-octagon-outline" title="Requested by" width="full"
                @click="show_requestor_selection=!show_requestor_selection" />
            <div x-show="show_requestor_selection">
                <livewire:merchant.financial-transaction.components.requestor-selection :$merchant
                    :$selected_requestor_ids event_id="RequestorSelection" />
            </div>
        </div>

        <div class="relative" @click.outside="show_salary_type_selection = false">
            <x-button.dropdown-icon-button icon="cash" title="Salary Type" width="full"
                @click="show_salary_type_selection=!show_salary_type_selection" />
            <div x-show="show_salary_type_selection">
                <livewire:merchant.financial-transaction.components.salary-type-selection :$merchant
                    wire:model="selected_salary_types" />
            </div>
        </div>
    </div>

    <div class="flex justify-end mb-4">
        <button wire:click="clear_filters" class="text-rp-red-500 text-sm underline">Clear filters</button>
    </div>

    @if ($errors->any())
        <ul class="flex flex-col gap-2 mb-4 text-red-500 text-xs list-disc list-inside">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <div class="flex justify-end mt-4 gap-2">
        <x-button.outline-button color="red" @click="$dispatch('closePayrollExportModal')" class="!border">
            Cancel
        </x-button.outline-button>
        <x-button.filled-button color="red" wire:click.prevent="export_csv" wire:loading.attr="disabled"
            wire:target="export_csv">
            Export CSV
        </x-button.filled-button>
    </div>
</div>
@script
    <script>
        Alpine.data('cashOutflowExport', () => ({
            show_type_selection: false,
            show_employee_selection: $wire.entangle('show_employee_selection'),
            show_requestor_selection: $wire.entangle('show_requestor_selection'),
            show_salary_type_selection: false,

            init() {
                this.$wire.on('setEmployeeSelection', () => {
                    this.show_employee_selection = false;
                });
                this.$wire.on('closeModalEmployeeSelection', () => {
                    this.show_employee_selection = false;
                });
                this.$wire.on('setRequestorSelection', () => {
                    this.show_requestor_selection = false;
                });
                this.$wire.on('closeModalRequestorSelection', () => {
                    this.show_requestor_selection = false;
                });
            }
        }));
    </script>
@endscript
