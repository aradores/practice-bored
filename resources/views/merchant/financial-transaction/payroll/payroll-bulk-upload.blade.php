<div class="flex flex-col py-10 px-4 min-h-[calc(100vh-60px)] h-full" x-data="payrollBulkSend">
    <div class="mb-5">
        <x-breadcrumb :items="[
            [
                'label' => 'Payroll',
                'href' => route('merchant.financial-transactions.payroll.index', ['merchant' => $merchant]),
            ],
            ['label' => 'Bulk Send'],
        ]" wire:ignore />
        <h1 class="font-bold text-rp-neutral-700 text-2xl">Bulk Send</h1>
    </div>
    @if (empty($file_data))
        <div class="flex justify-center pt-12 pb-20">
            <div class="relative flex flex-col items-center justify-center gap-3">
                <div>
                    <img src="{{ url('images/holding-a-wallet.png') }}" alt="Holding a Wallet" class="max-w-full h-auto">
                </div>
                <p>Uploaded payroll will appear here!</p>
                <x-button.filled-button class="w-max" @keyup.enter="$refs.uploaded_csv_file.click();">
                    <div role="button" class="flex flex-row gap-1 items-center">
                        <x-icon.send-square :color="'white'" width="20" height="20" />
                        <span>
                            upload csv file
                        </span>
                    </div>
                </x-button.filled-button>
                <input type="file" accept=".csv,.xlsx" class="absolute inset-0 h-full opacity-0 cursor-pointer"
                    wire:model="uploaded_csv_file" x-ref="uploaded_csv_file" id="uploaded_csv_file">
                <div wire:loading wire:target="uploaded_csv_file">Uploading...</div>
            </div>
        </div>
    @else
        <div class="bg-white mb-7 p-5 border rounded-[20px]">
            <div class="flex flex-row justify-between mb-4">
                <h2 class="font-bold text-rp-neutral-600 text-xl">Summary</h2>
                <div x-data>
                    <input type="file" accept=".csv,.xlsx" class="hidden" wire:model="uploaded_csv_file"
                        x-ref="uploaded_csv_file" id="uploaded_csv_file">

                    <button type="button"
                        class="flex flex-row items-center gap-2 px-3 py-1 hover:bg-rp-red-50 rounded-[9px] uppercase text-rp-red-500 font-bold"
                        @click="$refs.uploaded_csv_file.click()">
                        <x-icon.rotate-right color="#FF3D8F" />
                        <span>Replace CSV file</span>
                    </button>
                </div>


            </div>
            <div class="w-full overflow-auto mb-7">
                <table class="table-auto w-full border-collapse border border-rp-neutral-200">
                    <tr class="bg-rp-neutral-50">
                        <th class="text-left px-3 py-2 border border-rp-neutral-200">Employee Name</th>
                        <th class="text-left px-3 py-2 border border-rp-neutral-200">Phone Number</th>
                        <th class="text-left px-3 py-2 border border-rp-neutral-200">Base Salary</th>
                        <th class="text-left px-3 py-2 border border-rp-neutral-200">Deduction</th>
                        <th class="text-left px-3 py-2 border border-rp-neutral-200">Payout Date</th>
                        <th class="text-left px-3 py-2 border border-rp-neutral-200">Payout Time</th>
                        <th class="text-left px-3 py-2 border border-rp-neutral-200">Net Pay</th>
                        <th class="text-left px-3 py-2 border border-rp-neutral-200">Remarks</th>
                    </tr>
                    @foreach ($file_data as $tableIdx => $row)
                        <tr>
                            <td class="text-left px-3 py-2 border border-rp-neutral-200">{{ $row['name'] }}</td>
                            <td class="text-left px-3 py-2 border border-rp-neutral-200">{{ $row['phone_number'] }}
                            </td>
                            <td class="text-left px-3 py-2 border border-rp-neutral-200">
                                {{ Number::currency($row['gross_salary'], 'PHP') }}
                            </td>
                            <td class="text-left px-3 py-2 border border-rp-neutral-200">
                                {{ Number::currency($row['deductions'], 'PHP') }}
                            </td>
                            <td class="text-left px-3 py-2 border border-rp-neutral-200">{{ $row['payout_date'] }}
                            </td>
                            <td class="text-left px-3 py-2 border border-rp-neutral-200">{{ $row['payout_time'] }}
                            </td>
                            <td class="text-left px-3 py-2 border border-rp-neutral-200 text-primary-600 font-bold">
                                {{ $row['net_salary'] }}
                            </td>
                            <td class="text-left px-3 py-2 border border-rp-neutral-200">
                                @if (empty($row['remarks']))
                                    <span class="text-left px-3 py-2 text-rp-green-600">
                                        No errors.
                                    </span>
                                @else
                                    <ul class="text-left list-none  px-3 py-2 text-rp-red-600 list-inside">
                                        @foreach ($row['remarks'] as $remark)
                                            <li>{{ $remark }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </td>
                        </tr>
                    @endforeach

                </table>
            </div>
            <x-card.outflow class="mb-8" balance="{{ $total_balance }}" outflow="{{ $total_salary }}" />
            <div class="flex flex-row justify-end gap-2">
                <x-button.outline-button @click="openCancelSubmissionModal">cancel</x-button.outline-button>
                <x-button.filled-button @click="openFinalConfirmationModal" :disabled="!$can_submit">
                    {{ $can_approve ? 'Submit' : 'Submit for approval' }}
                </x-button.filled-button>
            </div>
        </div>
    @endif
    <div class="flex flex-row gap-2">
        <x-icon.important />
        <p>
            IMPORTANT: RePay follows a very specific format for uploading excel files. Please use our formatted excel
            file in order to ensure a smooth process for uploading payroll. If you don’t have a copy of our format yet,
            you can
            {{-- @TODO: handle csv download --}}
            <span wire:click="downloadFormat" @keyup.enter="$wire.downloadFormat" role="button" tabindex="0"
                class="underline font-semibold text-rp-red-500 cursor-pointer">
                download it here.
            </span>
        </p>
    </div>

    {{-- Cancel Submission Modal --}}
    <x-modal x-model="show_cancel_submission_modal">
        <x-modal.custom-confirmation-modal icon="contained-close" title="Cancel Submission?"
            message="Are you sure you want to cancel? What you have entered here will not be saved, and will be lost forever.">
            <x-slot:footer>
                <x-button.outline-button @click="closeCancelSubmissionModal">go back</x-button.outline-button>
                <x-button.filled-button
                    href="{{ route('merchant.financial-transactions.payroll.index', ['merchant' => $merchant]) }}">proceed</x-button.filled-button>
            </x-slot:footer>
        </x-modal.custom-confirmation-modal>
    </x-modal>

    {{-- FInal Confirmation Modal --}}
    <x-modal x-model="show_final_confirmation_modal" x-data="{ is_processing: $wire.entangle('is_processing') }">
        <x-modal.custom-confirmation-modal icon="contained-important" title="Final Confirmation"
            message="Please make sure you have thoroughly reviewed the summary before proceeding. Are you sure you want to proceed?">
            <x-slot:footer>
                <x-button.outline-button @click="closeFinalConfirmationModal">go back</x-button.outline-button>
                <x-button.filled-button x-on:click="$el.disabled = true" wire:click="submit"
                    x-bind:disabled="is_processing">proceed <div> </div> </x-button.filled-button>

            </x-slot:footer>
        </x-modal.custom-confirmation-modal>
    </x-modal>
</div>


@script
    <script>
        Alpine.data('payrollBulkSend', function() {
            return {
                is_processing: false,
                show_cancel_submission_modal: false,
                show_final_confirmation_modal: false,

                openCancelSubmissionModal() {
                    this.show_cancel_submission_modal = true;
                },

                openFinalConfirmationModal() {
                    this.show_final_confirmation_modal = true;
                },

                closeCancelSubmissionModal() {
                    this.show_cancel_submission_modal = false;
                },

                closeFinalConfirmationModal() {
                    this.show_final_confirmation_modal = false;
                },
            }
        });
    </script>
@endscript
