<div x-data="{
        isReasonModalVisible: false,
        editModal: false,
        selectedReason: '',
        editModal: @entangle('showEditModal')
    }"
    x-init="
        Livewire.on('openEditModal', selectedFeeId => {
            selectedFeeId = selectedFeeId;
            editModal = true;
        });
    ">
    @if (isset($merchant))
        <div class="w-full">
            <div class="w-1/3" wire:ignore>
                <x-date-picker.date-range-picker
                    id="fee-management"
                    :from='null'
                    :to='null'
                    :maxDateToday="false"
                    placeholder="Select a date range"
                    class="w-1/3"
                />
            </div>
        </div>
    @endif
    <div class="mt-6 py-5 px-4 bg-white rounded-2xl w-full">
        <x-main.title>Upcoming Rate Changes</x-main.title>
        <div class="overflow-auto w-full mt-6">
            <x-table.standard>
                <x-slot:table_header class="text-rp-neutral-600 [&>*]:px-4 [&>*]:py-0 [&>*]:pb-3 [&>*]:text-nowrap">
                    <x-table.standard.th class="w-40">Schedule Date</x-table.standard.th>
                    <x-table.standard.th class="w-32">Admin User</x-table.standard.th>
                    <x-table.standard.th class="w-32">Old Rate</x-table.standard.th>
                    <x-table.standard.th class="w-32">New Rate</x-table.standard.th>
                    <x-table.standard.th class="w-56">Type</x-table.standard.th>
                    <x-table.standard.th class="w-32">Reason for Change</x-table.standard.th>
                    <x-table.standard.th class="w-24">Action</x-table.standard.th>
                </x-slot:table_header>

                <x-slot:table_data>
                    @forelse ($upcoming_rate_changes['data'] as $upcoming_rate)
                    {{-- @dd($upcoming_rate) --}}
                        <x-table.standard.row class="text-sm">
                            <x-table.standard.td>{{ $upcoming_rate['date_time'] ?? '-' }}</x-table.standard.td>
                            <x-table.standard.td>{{ $upcoming_rate['admin_name'] ?? '-' }}</x-table.standard.td>
                            <x-table.standard.td> {{ $upcoming_rate['old_rate'] ?? '-' }} </x-table.standard.td>
                            <x-table.standard.td> {{ $upcoming_rate['new_rate'] ?? '-' }} </x-table.standard.td>
                            <x-table.standard.td> {{ $upcoming_rate['type_history'] ?? '-' }} </x-table.standard.td>

                            <x-table.standard.td>
                                <button
                                    class="text-primary-600 underline"
                                    @click="selectedReason = @js($upcoming_rate['reason']) ; isReasonModalVisible = true"
                                >
                                    View reason for change
                                </button>
                            </x-table.standard.td>

                            <x-table.standard.td>
                                <x-button.filled-button
                                    color="primary"
                                    class="w-full text-sm py-2 px-3"
                                    wire:click="editModal( {{ $upcoming_rate['id'] }} )"
                                    wire:loading.attr="disabled"
                                    wire:target="editModal( {{ $upcoming_rate['id'] }} )"
                                >
                                    Edit
                                </x-button.filled-button>
                            </x-table.standard.td>
                        </x-table.standard.row>
                    @empty
                        <tr colspan="full">
                            <td colspan="7" class="pt-8 pb-3 text-center align-middle">
                                No records
                            </td>
                        </tr>
                    @endforelse
                </x-slot:table_data>
            </x-table.standard>
        </div>
    </div>

    {{-- Change History --}}
    <div class="mt-6 py-5 px-4 bg-white rounded-2xl w-full">
        <x-main.title>Change History</x-main.title>
        <div class="overflow-auto w-full relative py-6 px-4 ">
            <div wire:loading.class="opacity-100 pointer-events-auto" wire:target="gotoPage" class="opacity-0 pointer-events-none absolute top-0 left-0 w-full h-full flex justify-center items-center transition-opacity duration-300 ease-in-out">
                <div class="shadow-lg bg-rp-neutral-600/80 px-12 py-8 rounded">
                    <div class="inline-block h-8 w-8 animate-spin rounded-full border-4 border-solid border-current border-e-transparent align-[-0.125em] text-surface animate-spin dark:text-white"
                        role="status">
                        <span class="!absolute !-m-px !h-px !w-px !overflow-hidden !whitespace-nowrap !border-0 !p-0 ![clip:rect(0,0,0,0)]">Loading...</span>
                    </div>
                </div>
            </div>
            <x-table.standard>
                <x-slot:table_header class="text-rp-neutral-600 [&>*]:px-4 [&>*]:py-0 [&>*]:pb-3 [&>*]:text-nowrap">
                    <x-table.standard.th class="w-40">Schedule Date</x-table.standard.th>
                    <x-table.standard.th class="w-32">Admin User</x-table.standard.th>
                    <x-table.standard.th class="w-32">Old Rate</x-table.standard.th>
                    <x-table.standard.th class="w-32">New Rate</x-table.standard.th>
                    <x-table.standard.th class="w-32">Type</x-table.standard.th>
                    <x-table.standard.th class="w-32">Reason for Change</x-table.standard.th>
                </x-slot:table_header>

                <x-slot:table_data>
                    @forelse ($change_history_records['data'] as $record)
                    {{-- @dd($record) --}}
                        <x-table.standard.row class="text-sm">
                            <x-table.standard.td>{{ $record['date_time'] }}</x-table.standard.td>
                            <x-table.standard.td>{{ $record['admin_name'] }}</x-table.standard.td>
                            <x-table.standard.td> {{ $record['old_rate'] }} </x-table.standard.td>
                            <x-table.standard.td> {{ $record['new_rate'] }} </x-table.standard.td>
                            <x-table.standard.td> {{ $record['type_history'] }} </x-table.standard.td>

                            <x-table.standard.td>
                                <button
                                    class="text-primary-600 underline"
                                    @click="selectedReason = @js($record['reason']) ; isReasonModalVisible = true"
                                >
                                    View reason for change
                                </button>
                            </x-table.standard.td>
                        </x-table.standard.row>
                    @empty
                        <tr colspan="full">
                            <td colspan="7" class="pt-8 pb-3 text-center align-middle">
                                No records
                            </td>
                        </tr>
                    @endforelse
                </x-slot:table_data>
            </x-table.standard>

            <div class="pagination mt-4 flex justify-center font-bold">
                <div class="flex flex-row items-center h-10 gap-2 mt-4 w-max rounded-md overflow-hidden [&>*]:border [&>*]:rounded">
                    {{-- Previous Button --}}
                    <button
                        wire:click="previousPage"
                        {{ $change_history_records['pagination']['current_page'] == 1 ? 'disabled' : '' }}
                        class="{{ $change_history_records['pagination']['current_page'] == 1 ? 'cursor-not-allowed opacity-40' : '' }} px-4 h-full py-2 bg-white flex items-center">
                        <svg width="7" height="13" viewBox="0 0 7 13" fill="none">
                            <path d="M6 11.5001L1 6.50012L6 1.50012" stroke="#647887" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>

                    {{-- Page Number Buttons --}}
                    @foreach ($elements as $element)
                        @if (is_string($element))
                            <button class="h-full px-4 py-2 bg-white border-r cursor-default">{{ $element }}</button>
                        @else
                            <button
                                wire:click="gotoPage({{ $element }})"
                                class="h-full border px-4 py-2 {{ $element == $change_history_records['pagination']['current_page'] ? 'cursor-default text-primary-600 border-primary-600' : 'cursor-pointer bg-white' }}">
                                {{ $element }}
                            </button>
                        @endif
                    @endforeach

                    {{-- Next Button --}}
                    <button
                        wire:click="nextPage"
                        {{ $change_history_records['pagination']['current_page'] == $change_history_records['pagination']['last_page'] ? 'disabled' : '' }}
                        class="{{ $change_history_records['pagination']['current_page'] == $change_history_records['pagination']['last_page'] ? 'cursor-not-allowed opacity-40' : '' }} px-4 h-full py-2 border-r bg-white flex items-center">
                        <svg width="7" height="13" viewBox="0 0 7 13" fill="none">
                            <path d="M1 1.50012L6 6.50012L1 11.5001" stroke="#647887" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>
                </div>
            </div>

        </div>
    </div>

    <x-modal x-model="isReasonModalVisible" @click="isReasonModalVisible = false">
        <div class="absolute flex flex-col gap-4 bg-white p-10 rounded-2xl w-[1180px] max-w-[40%] max-h-[95%] overflow-y-auto text-center" @click.stop>

            <button @click="isReasonModalVisible = false" class="absolute top-4 right-3" id="close-fee-change">
                <x-icon.close />
            </button>
            <p class="text-3xl font-bold">Fee Changes</p>
            <p class="whitespace-pre-line text-lg" x-text="selectedReason"></p>
        </div>
    </x-modal>

    @if (isset($selectedFeeId))
        <x-modal x-model="editModal">
        <div class="absolute flex flex-col gap-8 bg-white p-10 rounded-2xl w-[1180px] max-w-[55%] max-h-[95%] overflow-y-auto" @click.stop>
            <p class="text-2xl">Edit schedule fee</p>
            <button @click="editModal = false" class="absolute top-4 right-3">
                <x-icon.close />
            </button>

            <div class="text-gray-700">
                <livewire:admin.components.manage-fees.fee-form :fee_id="$selectedFeeId" :merchant="$merchant" wire:key="edit-{{ $selectedFeeId }}" />
            </div>
        </div>
    </x-modal>
    @endif
</div>
