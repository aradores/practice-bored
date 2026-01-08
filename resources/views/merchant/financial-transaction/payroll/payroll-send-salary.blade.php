<div class="flex flex-row border-r min-h-[calc(100vh-60px)] w-full h-full" x-data="sendSalary">
    @vite(['resources/js/flatpickr.js','resources/css/date-time-picker.css'])
    <div class="w-[calc(100%-450px)] py-10 px-4 border-r border-rp-neutral-100">
        <x-breadcrumb :items="[
            [
                'label' => 'Payroll',
                'href' => route('merchant.financial-transactions.payroll.index', ['merchant' => $merchant]),
            ],
            ['label' => 'Send Salary'],
        ]" wire:ignore />
        <h1 class="font-bold text-rp-neutral-700 text-2xl mb-5">Send Salary</h1>

        <div class="overflow-auto w-full mb-5">
            <table class="w-full table-auto">
                <tr class="border-b border-b-rp-neutral-100">
                    <th class="px-3 py-4 text-left font-bold min-w-32 max-w-32">Employee</th>
                    <th class="px-3 py-4 text-left font-bold min-w-36 max-w-36">Basic Salary</th>
                    <th class="px-3 py-4 text-left font-bold min-w-28 max-w-28">Deductions</th>
                    <th class="px-3 py-4 text-left font-bold min-w-48 max-w-48">Payout Date</th>
                    <th class="px-3 py-4 w-[16px]"></th>
                    {{-- Show Error Column if there's any error --}}
                    <template x-if="employeeHasErrors">
                        <th class="px-3 py-4 text-left font-bold min-w-24 max-w-24">
                            Error
                        </th>
                    </template>
                </tr>
                <template x-for="(employee, index) in employee_list" :key="index">
                    <tr class="border-b border-b-rp-neutral-100" x-data="{
                        selected_employee_id: null,
                        payout_date_label: 'Set Date',
                        is_set_date_dropdown_open: false,
                    }">
                        {{-- Employee --}}
                        <td class="relative px-3 py-4 min-w-32 max-w-32">
                            <div class="px-2 py-1 flex flex-row items-center gap-2 cursor-pointer rounded-lg hover:bg-rp-neutral-100" @click=
                                "() => {
                                    showSelectEmployeeDropdown($el, index);
                                }">
                                {{-- Profile --}}
                                <div class="min-w-10 min-h-10 bg-rp-neutral-300 rounded-full"></div>
                                <div class="w-[calc(100%-40px)] flex flex-row items-center justify-between gap-3" >
                                    <span x-text="employee.name ?? 'Select employee'"></span>
                                    <x-icon.thin-arrow-down />
                                </div>
                            </div>
                        </td>
                        {{-- Basic Salary --}}
                        <td class="px-3 py-4 min-w-40 max-w-40">
                            <template x-if="employee.salary_type === null">
                                <span>---</span>
                            </template>
                            <template x-if="employee.salary_type === 'Per Day'">
                                <div class="flex flex-row items-baseline gap-1">
                                    <span x-text="formatToPesoCurrency(employee.basic_salary.value) ?? '---'"></span>
                                    <span>x</span>
                                    <div class="flex flex-col">
                                        <div class="relative">
                                            <x-input type="number" x-model.number="employee.basic_salary.days" class="pr-14 text-sm" min="1" />
                                            <span class="absolute top-[50%] -translate-y-[50%] right-4">days</span>
                                        </div>
                                        <template x-for="(err, index) in employee['errors']['days']" :key="index">
                                            <span class="text-xs text-red-600" x-text="err"></span>
                                        </template>
                                    </div>
                                </div>
                            </template>
                            <template x-if="employee.salary_type === 'Per Cutoff'">
                                <div class="flex flex-row items-center gap-1">
                                    <span x-text="formatToPesoCurrency(employee.basic_salary.value)"></span>
                                </div>
                            </template>
                        </td>
                        {{-- Deductions --}}
                        <td class="px-3 py-4 min-w-28 max-w-28">
                            <div class="relative">
                            <x-input type="text" x-model="employee.deductions" placeholder="0.00" x-mask:dynamic="$money($input)" class="pl-11" />
                                <div class="absolute left-4 z-10 top-[50%] -translate-y-[50%]">
                                    <x-icon.peso-sign />
                                </div>
                            </div>
                        </td>
                        {{-- Payout Date --}}
                        <td class="px-3 py-4 min-w-48 max-w-48">
                            <div class="relative" x-data="{ x: 0, y: 0, width: 0 }" >
                                <div>
                                    <div class="relative py-2 focus:outline-none bg-white border border-rp-neutral-500 rounded-lg cursor-pointer  text-rp-neutral-700" 
                                        @click="() => {
                                            const rect = $el.getBoundingClientRect();
                                            width = $el.offsetWidth;
                                            x = rect.left;
                                            y = rect.bottom;
                                            is_set_date_dropdown_open = true;
                                        }"
                                        @click.away="(e) => {
                                            const dateTimeButton = document.querySelector(`.date_time_button-${index}`);

                                            if (e.target.contains(dateTimeButton) || e.target.closest('.flatpickr-calendar.hasTime')) {
                                                return;
                                            }
                                            is_set_date_dropdown_open = false;
                                        }"
                                    >
                                        <div class="absolute left-4 z-10 top-[50%] -translate-y-[50%]"> 
                                            <x-icon.calendar-outline width="20" height="20" color="#647887" />
                                        </div>
                                        <div class="flex flex-row gap-2">
                                            <span class="pl-11" x-text="payout_date_label"></span>
                                            <div class="absolute right-4 z-10 top-[50%] -translate-y-[50%]">
                                                <div class="min-w-max">
                                                    <x-icon.thin-arrow-down />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <template x-if="employee['errors']['date']">
                                        <span class="text-xs text-red-600" x-text="employee['errors']['date']"></span>
                                    </template>
                                </div>

                                <template x-teleport="body">
                                    <div x-cloak x-show="is_set_date_dropdown_open" 
                                    :style="`top: ${y}px; left: ${x}px; width: ${width}px`"
                                    class="absolute left-0 top-[calc(100%+4px)] flex flex-col bg-white rounded-md shadow-sm border z-10">
                                        <button class="px-3 py-2 cursor-pointer hover:bg-rp-neutral-100 text-left" @click="() => {
                                            employee.payout_date = 'Immediate';
                                            payout_date_label = 'Immediate';
                                        }">Immediate</button>
                                        <button x-init="flatpickr($el, {
                                            enableTime: true,
                                            noCalendar: false,
                                            dateFormat: 'Y-m-d h:i K',
                                            minTime: '00:00', 
                                            maxTime: '23:59',
                                            onChange: (selectedDates, dateStr, instance) => {
                                                employee.payout_date = dateStr;
                                                payout_date_label = dateStr;
                                            },
                                        })" :class="`date_time_button-${index} px-3 py-2 cursor-pointer hover:bg-rp-neutral-100 text-left`">Date & time</button>
                                    </div>
                                </template>
                            </div>
                        </td>
                        {{-- Remove --}}
                        <td class="px-3 py-4 w-[16px]">  
                            <div class="cursor-pointer w-max" @click="handleRemoveRow(index)">
                                <x-icon.close-no-border />
                            </div>
                        </td>
                        <template x-if="employee['errors'].length > 0">
                            <td class="px-3 py-4 max-w-24">
                                <div class="flex flex-col">
                                    <template x-for="(err, idx) in employee['errors']" :key="idx">
                                        <span x-text="err" class="text-red-500 text-xs"></span>
                                    </template>
                                </div>
                            </td>
                        </template>                            
                    </tr>
                </template>
            </table>
        </div>
        <div class="flex flex-row items-center justify-end gap-1">
            <x-button.outline-button class="!border" @click="handleAddAllEmployeesButton">
                <div class="flex flex-row gap-1 items-center">
                    <x-icon.user fill="#FF3D8F" />
                    <span>add all employees</span>
                </div>
            </x-button.outline-button>
            {{-- Add button --}}
            <div class="relative" x-data="{ show_add_dropdown: false }" @click.away="closeSelectEmployeeDropdown();clearSelectEmployeeModel();">
                <div id="create-card" class="flex flex-row items-stretch">
                    <span @click="handleAddButtonClick" class="cursor-pointer flex items-center rounded-tl-lg rounded-bl-lg bg-rp-red-500 hover:bg-rp-red-600 text-white text-sm font-bold uppercase p-2.5 border-r border-white"
                        :class="{ 'bg-rp-red-600': show_add_dropdown }">
                        Add
                    </span>
                    <div class="relative flex items-stretch" >
                        <button @click="show_add_dropdown=!show_add_dropdown"
                            class="flex items-center rounded-tr-lg rounded-br-lg bg-rp-red-500 hover:bg-rp-red-600 text-white p-2.5 border-r border-white"
                            :class="{ 'bg-rp-red-600': show_add_dropdown }">
                            <x-icon.triangle-down width="16" height="16" color="#ffffff" />
                        </button>
                    </div>
                </div>
                {{-- Add Employee Dropdown --}}
                <div x-cloak x-show="show_add_dropdown" class="absolute mt-1 right-0 w-96 rounded-lg shadow-md p-4 bg-white text-rp-neutral-700 flex flex-col gap-2 z-20">
                    <div class="flex justify-between items-center">
                        <h2 class="font-semibold" x-text="`${selected_employee_model.length} selected`"></h2>
                        <x-button.outline-button @click="handleSelectAllEmployeeButton" color="red" class="p-2.5 text-sm">Select
                            All</x-button.outline-button>
                    </div>

                    <x-input.search icon_position="left" x-model="search_term" placeholder="Search" />

                    <div class="flex flex-col gap-2 max-h-64 overflow-y-auto">
                        <template x-for="(unselected_employee,index) in filtered_unselected_employees" :key="index">
                            <label class="flex items-center justify-between p-3 rounded-lg cursor-pointer hover:bg-gray-100 transition">
                                <div class="flex items-center space-x-3">
                                    <div>
                                        <p class="font-bold text-sm text-rp-neutral-500" x-text="unselected_employee.name"></p>
                                        <p class="text-sm text-rp-neutral-600" x-text="unselected_employee.phone_number"></p>
                                    </div>
                                </div>
                                <input type="checkbox" class="form-checkbox w-5 h-5 text-rp-red-500" x-model.number="selected_employee_model" x-bind:value="unselected_employee.id"
                                    />
                            </label>
                        </template>
                    </div>

                    <!-- Footer Buttons -->
                    <div class="flex justify-end gap-2">
                        <x-button.outline-button color="red" @click="closeSelectEmployeeDropdown();clearSelectEmployeeModel();"
                            class="!p-2.5 text-sm !border">cancel</x-button.outline-button>

                        <x-button.filled-button color="red" @click="handleAddMultipleEmployees"
                            class="!p-2.5 text-sm">add</x-button.filled-button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="payrollSummary" class="min-w-[450px] h-full w-1/3 p-4">
        <x-ui.summary class="w-full h-full">
            <x-slot:body>
                <div class="overflow-auto w-full">
                    <x-table.standard>
                        <x-slot:table_header>
                            <x-table.standard.th class="max-w-32">Employee</x-table.standard.th>
                            <x-table.standard.th class="max-w-32">
                                <div class="flex items-center">
                                    <p>Basic Salary</p>
                                    <button @click="sortTable('basic_salary')">
                                        <x-icon.sort />
                                    </button>
                                </div>
                            </x-table.standard.th>
                            <x-table.standard.th class="max-w-32">
                                <div class="flex items-center">
                                    <p>Deductions</p>
                                    <button @click="sortTable('deductions')">
                                        <x-icon.sort />
                                    </button>
                                </div>
                            </x-table.standard.th>
                            <x-table.standard.th class="max-w-32">
                                <div class="flex items-center">
                                    <p>Net Pay</p>
                                    <button @click="sortTable('net_pay')">
                                        <x-icon.sort />
                                    </button>
                                </div>
                            </x-table.standard.th>
                            <x-table.standard.th class="max-w-32">
                                <div class="flex items-center">
                                    <p>Payout Date</p>
                                    <button @click="sortTable('payout_date')">
                                        <x-icon.sort />
                                    </button>
                                </div>
                            </x-table.standard.th>
                        </x-slot:table_header>
                        <x-slot:table_data>
                            <template x-for="(employee,index) in summary_employee_list" :key="index">
                                <x-table.standard.row>
                                    {{-- Employee --}}
                                    <x-table.standard.td class="max-w-32" x-text="employee.name">
                                    </x-table.standard.td>
                                    {{-- Basic Salary --}}
                                    <x-table.standard.td class="max-w-32" x-text="formatToPesoCurrency(employee.basic_salary.value)">
                                    </x-table.standard.td>
                                    {{-- Deductions --}}
                                    <x-table.standard.td class="max-w-32" x-text="!employee.deductions ?  '---' : !isNaN(removeComma(employee.deductions)) ? formatToPesoCurrency(removeComma(employee.deductions)) : '---'">
                                    </x-table.standard.td>
                                    {{-- Net Pay --}}
                                    <x-table.standard.td class="max-w-32 text-primary-800 font-bold" x-text="formatToPesoCurrency(employee.net_pay)">
                                    </x-table.standard.td>
                                    {{-- Payout Date --}}
                                    <x-table.standard.td class="max-w-32" x-text="employee.payout_date ?? 'No Target Date'">
                                    </x-table.standard.td>
                                </x-table.standard.row>
                            </template>
                        </x-slot:table_data>
                    </x-table.standard>
                </div>
                <div class="relative py-6 pl-6 pr-36 bg-primary-100 border border-primary-700 rounded-2xl w-full flex flex-col overflow-hidden">
                    <div class="flex flex-col justify-between">
                        {{-- Available balance: --}}
                        <div class="flex flex-row items-center text-primary-700 gap-3">
                            <span class="text-base">Available Balance:</span>
                            <strong class="text-xl" x-text="formatToPesoCurrency(balance)"></strong>
                        </div>
                        {{-- Estimated Total Outflow: --}}
                        <div class="flex flex-row items-center text-rp-red-600 gap-3">
                            <span class="text-sm">Estimated Total Outflow:</span>
                            <strong class="text-sm" x-text="`-${formatToPesoCurrency(Math.abs(total_outflow))}`"></strong>
                        </div>
                        {{-- Available balance After Outflow: --}}
                        <div class="flex flex-row items-center text-primary-700 gap-3">
                            <span class="text-sm">Available Balance After Outflow:</span>
                            <strong class="text-sm" x-text="formatToPesoCurrency(balance_after_outflow)"></strong>
                        </div>
                    </div>
                    {{-- Icon --}}
                    <div class="absolute top-0 right-0">
                        <img src="{{ url('images/purple-wallet.png') }}" />
                    </div>
                </div>
            </x-slot:body>
            <x-slot:action>
                <div class="flex flex-col gap-2">
                    <x-button.filled-button @click="handleSubmitForApproval" {{-- wire:click="submit" wire:target="submit" --}} wire:loading.attr="disabled">
                        submit
                    </x-button.filled-button>
                    <x-button.outline-button href="{{ route('merchant.financial-transactions.payroll.index', ['merchant' => $merchant]) }}">
                        cancel
                    </x-button.outline-button>
                </div>
            </x-slot:action>
        </x-ui.summary>
    </div>

    {{-- Display employee selection here --}}
    <template x-teleport="body">
        <div 
            x-cloak x-show="is_select_employee_dropdown_open"
            :style="`top: ${select_employee_button_bottom_position}px; left: ${select_employee_button_left_position}px;`"
            @click.away="is_select_employee_dropdown_open = false;row_index = -1;"
            class="employee-selection absolute mt-1 right-0 w-96 rounded-lg shadow-md p-4 bg-white text-rp-neutral-700 flex flex-col gap-2 z-20">
            <x-input.search icon_position="left" placeholder="Search" class="mb-3" />
            {{-- List --}}
            <template x-if="filtered_unselected_employees.length < 1">
                <span class="text-center text-sm font-thin">Empty</span>
            </template>
            <template x-if="filtered_unselected_employees.length > 0">
                <div class="w-full flex flex-col gap-1">
                    <template x-for="(employee,index) in filtered_unselected_employees" :key="index">
                        <div class="flex flex-row items-center hover:bg-rp-neutral-50 px-3 py-2 rounded-lg cursor-pointer" @click="handleSelectEmployeeClick(employee)">
                            {{-- Profile --}}
                            <div class="w-10 h-10 bg-rp-neutral-300 rounded-full"></div>
                            {{-- Details --}}
                            <div class="pl-3 flex flex-col">
                                <strong class="text-rp-neutral-600" x-text="employee.name"></strong>
                                <span x-text="employee.phone_number"></span>
                            </div>
                        </div>
                    </template>
                </div>
            </template>
        </div>
    </template>
</div>


@script
    <script>
        Alpine.data('sendSalary', () => {
            return {
                employee_list: [], // { id, name, salary_type, basic_salary: { value, day }, deductions, payout_date }
                is_select_employee_dropdown_open: false,
                merchant_employees: @js($this->merchant_employees),
                search_term: '',
                select_employee_button_left_position: 0,
                select_employee_button_bottom_position: 0,
                row_index: -1,
                selected_employee_model: [],
                balance: parseFloat(@js($this->available_balance)),
                
                employee: {
                    id: null,
                    name: null,
                    salary_type: null,
                    basic_salary: {
                        value: null,
                        day: null,
                    },
                    deductions: null,
                    payout_date: 'Set Date',
                    errors: [],
                },

                // Summary table
                sort_column: null,
                sort_direction: null,
                
                init() {
                    this.$wire.on('resetData', (data) => {
                        this.employee_list = [];
                        this.balance = parseFloat(data.balance);
                    });
                    
                    this.$wire.on('loadValidationErrors', (err) => {
                        const [errors] = err;

                        for (let [e_id, error_messages] of Object.entries(errors)) {
                            const employee_id = parseInt(e_id);
                            const target_employee_index = this.employee_list.findIndex(emp => emp.id === employee_id);
                            if (target_employee_index !== -1) {
                                this.employee_list[target_employee_index]['errors'] = error_messages;
                            }
                        }
                    });
                },

                get unselected_employees() {
                    return this.merchant_employees.filter(merchant_emp => {
                        return !this.employee_list.some(emp => merchant_emp.id === emp.id);
                    });
                },
                
                get filtered_unselected_employees() {
                    if (!this.search_term) {
                        return this.unselected_employees;
                    }
                    
                    return this.unselected_employees.filter(emp => emp.name.toLowerCase().includes(this.search_term.toLowerCase()));
                },
                
                get target_employees() {
                    return this.employee_list.filter(emp => emp.id !== null);
                },  

                get summary_employee_list() {
                    
                    let summary_employee_list = this.target_employees.map(emp => {
                        const net_pay = this.calculateNetPay(emp);
                        return {
                            ...emp,
                            net_pay
                        }
                    });
                    switch(this.sort_direction) {
                        case 'desc':
                            if (this.sort_column === 'deductions' || this.sort_column === 'basic_salary') {
                                summary_employee_list.sort((a,b) => parseFloat(b[this.sort_column].value) - parseFloat(a[this.sort_column].value));
                            }

                            if (this.sort_column === 'net_pay') {
                                summary_employee_list.sort((a,b) => b[this.sort_column] - a[this.sort_column]);
                            }

                            if (this.sort_column === 'payout_date') {
                                summary_employee_list.sort((a,b) => new Date(b[this.sort_column]) - new Date(a[this.sort_column]));
                            }
                            break;
                        case 'asc':
                            if (this.sort_column === 'deductions' || this.sort_column === 'basic_salary') {
                                summary_employee_list.sort((a,b) => parseFloat(a[this.sort_column].value) - parseFloat(b[this.sort_column].value));
                            }

                            if (this.sort_column === 'net_pay') {
                                summary_employee_list.sort((a,b) => a[this.sort_column] - b[this.sort_column]);
                            }

                            if (this.sort_column === 'payout_date') {
                                summary_employee_list.sort((a,b) => new Date(a[this.sort_column]) - new Date(b[this.sort_column]));
                            }
                            break;
                        default:
                    }

                    return summary_employee_list;

                },

                get total_outflow() {
                    return this.summary_employee_list.reduce((sum, emp) => sum + Math.max(0, emp.net_pay), 0); // Change negative net pay value with 0 using Math.max
                },

                get balance_after_outflow() {
                    return this.balance - this.total_outflow;
                },

                get allowed_column() {
                    return ['basic_salary', 'deductions', 'net_pay', 'payout_date'];
                },

                get employeeHasErrors() {
                    return this.employee_list.some(emp => emp.errors.length > 0);
                },

                sortTable(column) {
                    let target_column = column;
                    
                    if (this.allowed_column.includes(target_column)) {
                        target_column = 'basic_salary';
                    }

                    if (this.sort_column === null) {
                        this.sort_column = target_column;
                    }                     
                    
                    if (this.sort_direction === null) {
                        this.sort_direction = '';
                    }
                    
                    if (this.sort_column === target_column) {
                        this.sort_direction = this.sort_direction === 'desc' ? 'asc' : 'desc';
                    } else {
                        this.sort_column = target_column;
                        this.sort_direction = 'desc';
                    } 

                },

                removeComma(str) {
                    return str?.replace(/,/g, '');
                },

                formatToPesoCurrency(amount) {
                    return new Intl.NumberFormat("en-PH", {
                        style: "currency",
                        currency: "PHP",
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2,
                    }).format(amount);
                },  

                calculateNetPay(employee) {
                    let basic_salary = parseFloat(employee.basic_salary.value);
                    
                    if (employee.salary_type === 'Per Day') {
                        basic_salary = employee.basic_salary.days === null ? 
                            basic_salary : 
                            basic_salary * employee.basic_salary.days;
                    }   

                    let deductions = 0;

                    if (employee.deductions !== null && employee.deductions !== '') {
                        const cleanDeductions = parseFloat(this.removeComma(employee.deductions));

                        if (!isNaN(cleanDeductions)) {
                            deductions = cleanDeductions;
                        }
                    }
                    
                    const net_pay = basic_salary - Math.abs(deductions);

                    return net_pay;
                },

                handleRemoveRow(index) {
                    this.employee_list.splice(index, 1);   
                },

                handleSelectEmployeeClick(employee) {
                    this.employee_list[this.row_index] = {
                        id: employee.id,
                        name: employee.name,
                        salary_type: employee.salary_type,
                        basic_salary: {
                            value: employee.salary,
                            days: null,
                        },
                        deductions: this.employee_list[this.row_index].deductions ?? null,
                        payout_date: this.employee_list[this.row_index].payout_date ?? null,
                        errors: []
                    };
                    this.is_select_employee_dropdown_open = false;
                    this.row_index = -1;
                },
                
                showSelectEmployeeDropdown(el, row_index) {
                    const rect = el.getBoundingClientRect();
                    this.select_employee_button_left_position = rect.left;
                    this.select_employee_button_bottom_position = rect.bottom;
                    this.is_select_employee_dropdown_open = true;
                    this.row_index = row_index;
                }, 

                handleAddAllEmployeesButton() {
                    this.merchant_employees.forEach(merchant_emp => {
                        if (this.employee_list.findIndex(emp => emp.id === merchant_emp.id) === -1) {
                            this.employee_list.push({
                                id: merchant_emp.id,    
                                name: merchant_emp.name,
                                salary_type: merchant_emp.salary_type,
                                basic_salary: {
                                    value: merchant_emp.salary,
                                    days: null,
                                },
                                deductions: null,
                                payout_date: 'Set Date',
                                errors: []
                            });
                        }
                    });
                },
            
                handleSelectAllEmployeeButton() {
                    this.search_term = '';
                    this.selected_employee_model = this.filtered_unselected_employees.map(emp => emp.id);
                },

                handleAddButtonClick() {
                    const employee_cleaned_object = JSON.parse(JSON.stringify(this.employee));
                    this.employee_list.push(employee_cleaned_object);
                },

                handleAddMultipleEmployees() {
                    this.selected_employee_model.forEach(employee_id => {
                        const target_employee = this.filtered_unselected_employees.find(filtered_unselected_employee => filtered_unselected_employee.id === employee_id);
                        if (!target_employee) return;
                        this.employee_list.push({
                            ...this.employee, 
                            id: target_employee.id, 
                            name: target_employee.name, 
                            salary_type: target_employee.salary_type,
                            basic_salary: {
                                value: target_employee.salary,
                                days: null
                            }
                        });
                    }); 
                    this.closeSelectEmployeeDropdown();
                    this.clearSelectEmployeeModel();
                },
                
                closeSelectEmployeeDropdown() {
                    this.search_term = '';
                    this.show_add_dropdown = false;
                },
                
                clearSelectEmployeeModel() {
                    this.selected_employee_model = [];
                },

                validateEmployees() {
            
                    const employeeError = {};

                    const target_employees = this.target_employees;

                    // Check each employee to check for error
                    target_employees.forEach(emp => {
                        let day_field_error = [];
                        let date_field_error = [];

                        // Handle validation for days field
                        if (emp.salary_type === 'Per Day') {
                            if (emp.basic_salary.days === null) {
                                day_field_error.push('The day field is required');
                            } 
                            
                            if (emp.basic_salary.days <= 0) {
                                day_field_error.push("The day field can't be less than 1");
                            }
                        }

                        // Handle validation for date field
                        if (emp.payout_date === 'Set Date') {
                            date_field_error.push('The date field is required');
                        }

                        employeeError[emp.id] = [...day_field_error, ...date_field_error];

                    });
                    
                    // Assign error for each employee
                    for (let [e_id, errors] of Object.entries(employeeError)) {
                        
                        const employee_id = parseInt(e_id);
                        const target_employee_index = this.employee_list.findIndex(emp => emp.id === employee_id);
                        
                        if (target_employee_index !== -1) {
                            this.employee_list[target_employee_index]["errors"] = errors;
                        }

                    }
                    
                },

                handleSubmitForApproval() {
                    // Run validation for employee_list
                    if (this.summary_employee_list.length <= 0) return;

                    // Run client-side validation for employees
                    this.validateEmployees();

                    if (this.employeeHasErrors) {
                        return;
                    }

                    function calculateGrossPay(employee) {
                        let total_salary = parseFloat(employee.basic_salary.value);
                        
                        if (employee.salary_type === 'Per Day') {
                            total_salary = employee.basic_salary.days === null ? 
                            total_salary : 
                            total_salary * employee.basic_salary.days;
                        }
                        
                        return total_salary;
                    }

                    const employee_list_cleaned = () => { 
                        return this.summary_employee_list.map(emp => {
                            return {
                                id: emp.id,
                                gross_salary: calculateGrossPay(emp),
                                deductions: emp.deductions ?? 0,
                                payout_date: emp.payout_date === 'Immediate' ? null : emp.payout_date, 
                            }
                        });
                    };

                    this.$wire.submit(employee_list_cleaned());
                },

            }
        });
        Alpine.data('selectEmployee', () => {
            return {
                x: 0, 
                y: 0, 
                isSelectEmployeeDropdownOpen: false,
            }
        });
    </script>
@endscript