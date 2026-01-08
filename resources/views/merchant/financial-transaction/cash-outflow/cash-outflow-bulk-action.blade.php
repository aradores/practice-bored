<div class="bg-white flex flex-col justify-between h-full w-[900px] p-6 overflow-y-auto" @click.away="$wire.dispatch('closeModal')"
    x-data="requestBulkAction">
    <div>
        <div class="text-rp-neutral-700">
            <strong class="text-2xl">{{ $title }}</strong>
            <span class="text-sm block">{{ $sub_title }}</span>
        </div>
        <div class="mt-8 space-y-6">
            <div>
                <div id="table_wrapper" class="overflow-auto w-full mt-5">
                    <x-table.standard class="overflow-auto max-w-full w-full text-sm text-rp-neutral-700">
                        <x-slot:table_header>
                            <x-table.standard.th class="max-w-20 text-center">
                            </x-table.standard.th>
                            <x-table.standard.th class="max-w-52">
                                Transaction Type
                            </x-table.standard.th>
                            {{-- <x-table.standard.th class="max-w-52">
                                Destination
                            </x-table.standard.th> --}}
                            <x-table.standard.th class="max-w-52 text-left">
                                Recipient
                            </x-table.standard.th>
                            <x-table.standard.th class="max-w-40">
                                <div class="flex flex-row items-center gap-2">
                                    <div>Amount</div>
                                    @php
                                        $amount_sort_direction = '';
                
                                        if ($sort_by === 'total_amount') {
                                            $amount_sort_direction = $sort_direction === 'desc' ? 'down' : 'up';
                                        } else {
                                            $amount_sort_direction = 'both';
                                        }
                
                                    @endphp
                                    <button wire:click="changeSorting('total_amount')"><x-icon.sort
                                            :direction="$amount_sort_direction" /></button>
                                </div>
                            </x-table.standard.th>
                            <x-table.standard.th class="max-w-52">
                                <div class="flex flex-row items-center gap-2">
                                    <div>Date Created</div>
                                    @php
                                        $date_created_sort_direction = '';
                
                                        if ($sort_by === 'created_at') {
                                            $date_created_sort_direction = $sort_direction === 'desc' ? 'down' : 'up';
                                        } else {
                                            $date_created_sort_direction = 'both';
                                        }
                
                                    @endphp
                                    <button wire:click="changeSorting('created_at')"><x-icon.sort
                                            :direction="$date_created_sort_direction" /></button>
                                </div>
                            </x-table.standard.th>
                            <x-table.standard.th class="max-w-52">
                                <div class="flex flex-row items-center gap-2">
                                    <div>Created By</div>
                                    @php
                                        $created_by_sort_direction = '';
                
                                        if ($sort_by === 'creator_name') {
                                            $created_by_sort_direction = $sort_direction === 'desc' ? 'down' : 'up';
                                        } else {
                                            $created_by_sort_direction = 'both';
                                        }
                
                                    @endphp
                                    <button wire:click="changeSorting('creator_name')"><x-icon.sort
                                            :direction="$created_by_sort_direction" /></button>
                                </div>
                            </x-table.standard.th>
                        </x-slot:table_header>
                        <x-slot:table_data>
                            @foreach ($this->transaction_requests as $request)
                                <x-table.standard.row class="text-rp-neutral-600" wire:key="request-{{ $request->id }}">
                                    <x-table.standard.td class="max-w-20 text-center">
                                        <x-input type="checkbox" x-model.number="selected_ids" value="{{ $request->id }}" />
                                    </x-table.standard.td>
                                    <x-table.standard.td class="max-w-52">
                                        {{ $request->type->name }}
                                    </x-table.standard.td>
                                    {{-- <x-table.standard.td class="max-w-52">
                                        {{ $request->destination_name }}
                                    </x-table.standard.td> --}}
                                    <x-table.standard.td class="max-w-52">
                                        <div class="flex text-left flex-col items-start">
                                            <span>{{ $request->recipient_name }}</span>
                                            @if (isset($request->recipient_display_name))
                                                <span>{{ $request->recipient_display_name }}</span>
                                            @endif
                                        </div>
                                    </x-table.standard.td>
                                    <x-table.standard.td class="max-w-40 text-primary-800 font-bold">
                                        {{ Number::currency($request->total_amount, $request->currency) }}
                                    </x-table.standard.td>
                                    <x-table.standard.td class="max-w-52">
                                        {{ \Carbon\Carbon::parse($request->created_at)->timezone('Asia/Manila')->format('F j, Y') }}
                                    </x-table.standard.td>
                                    <x-table.standard.td class="max-w-52">
                                        {{ $request->creator_name }}
                                    </x-table.standard.td>
                                </x-table.standard.row>
                            @endforeach
                        </x-slot:table_data>
                    </x-table.standard>
                </div>
                
                <div class="flex items-center justify-center w-full gap-8">
                    {{ $this->transaction_requests->links('pagination.standard-pagination') }}
                </div>
            </div>
            
            @if ($action == 'reject')
                <x-input.input-group>
                    <x-slot:label>
                        <span class="text-rp-dark-pink-600">*</span> Reason for cancellation
                    </x-slot:label>
                    <div>
                        <x-input.textarea wire:model='reject_reason' class="w-full" x-ref='reject_reason' maxlength="1000"
                            rows="6" placeholder="e.g., 'Incorrect details', 'Need to update amount', etc." />
                        <div class="flex justify-between items-start leading-none">
                            <div>
                                @error('reject_reason')
                                    <p class="text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                            <p class="text-right text-[11px]">
                                <span x-html="$wire.reject_reason.length"></span>/<span x-html="$refs.reject_reason.maxLength"></span>
                            </p>
                        </div>
                    </div>
                </x-input.input-group>
            @elseif ($action === 'approve')
                <div class="relative py-6 pl-6 pr-36 bg-primary-100 border border-primary-700 rounded-2xl w-full flex flex-col overflow-hidden">
                    <div class="flex flex-row justify-between max-w-[80%]">
                        {{-- Available balance: --}}
                        <div class="flex flex-col text-primary-700 gap-3">
                            <span class="text-base">Available Balance:</span>
                            <strong class="text-xl" x-text="formatToPesoCurrency(balance)"></strong>
                        </div>
                        {{-- Estimated Total Outflow: --}}
                        <div class="flex flex-col text-rp-red-600 gap-3">
                            <span class="text-base">Estimated Total Outflow:</span>
                            <strong class="text-xl" x-text="`-${formatToPesoCurrency(total_outflow)}`">-</strong>
                        </div>
                        {{-- Available balance After Outflow: --}}
                        <div class="flex flex-col text-primary-700 gap-3">
                            <span class="text-base">Available Balance After Outflow:</span>
                            <strong class="text-xl" x-text="formatToPesoCurrency(balance_after_outflow)"></strong>
                        </div>
                    </div>
                    {{-- Icon --}}
                    <div class="absolute top-0 right-0">
                        <img src="{{ url('images/purple-wallet.png') }}" />
                    </div>
                </div>
            @endif
        </div>

    </div>
    <div class="ml-auto mt-8">
        <x-button.outline-button class="!border" @click="$wire.dispatch('closeModal')">cancel</x-button.outline-button>
        <x-button.filled-button class="!border" @click="submit"
        x-bind:disabled="{{ $action === 'approve' ? 'total_outflow > balance || total_outflow <= 0' : 'false' }}">
            {{ $action }}
            (<span x-text="selected_ids.length"></span>)
        </x-button.filled-button>
    </div>
</div>


@script
    <script>
        Alpine.data('requestBulkAction', () => ({
            action: @js($action),
            selected_ids: @js($selected_ids),
            transaction_request: @js($this->transaction_requests_total_amount),
            balance: parseFloat(@js($this->available_balance)),

            get total_outflow() {
                return this.transaction_request
                    .filter(({id}) => this.selected_ids.includes(id))
                    .reduce((acc, curr) => acc + curr.total_amount, 0);
            },

            get balance_after_outflow() {
                return this.balance - this.total_outflow;
            }, 

            formatToPesoCurrency(amount) {
                return new Intl.NumberFormat("en-PH", {
                    style: "currency",
                    currency: "PHP",
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2,
                }).format(amount);
            },

            submit() {
                if (this.action == 'approve') {
                    return $wire.bulkApprove(this.selected_ids);
                }
                return $wire.bulkReject(this.selected_ids);
            }
        }));
    </script>
@endscript
