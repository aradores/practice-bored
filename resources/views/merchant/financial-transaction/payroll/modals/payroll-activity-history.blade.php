<div class="bg-white flex flex-col h-full w-[483px] px-6 pb-6 overflow-y-auto" @click.away="$wire.dispatch('closeModal')">
    <div class="sticky top-0 flex flex-col gap-2.5 py-6 border-b-2 border-rp-neutral-100 bg-white">
        <div class="flex flex-row justify-between items-center">
            <h1 class="text-2xl font-bold text-rp-neutral-700">Payroll Activity History</h1>
            <button @click="$dispatch('closeModal')">
                <x-icon.close-no-border width="24" height="24" color="#647887" />
            </button>
        </div>

        {{-- TODO: handle width --}}
        <div class="w-40 relative">
            <x-date-picker.date-range-picker :from="$from_date" :to="$to_date" placeholder="ALL TIME"
                id="activity_history" />
        </div>
    </div>
    <div class="flex flex-col gap-8 px-1 py-3">
        @foreach ($activities as $key => $activity_items)
            <div class="flex flex-col gap-2.5 {{ $loop->last ? '' : 'pb-8 border-b-2 border-rp-neutral-100' }}"
                wire:key="activity-{{ $key }}">
                <div
                    class="rounded-3xl p-2 w-fit text-white {{ $loop->first ? 'bg-primary-600' : 'bg-rp-neutral-300' }}">
                    {{ $key }}
                </div>
                <div class="flex flex-col gap-6">
                    @foreach ($activity_items as $activity)
                        <div>
                            <div class="p-3 flex flex-col bg-white border-2 border-rp-neutral-100 rounded-lg">
                                <div class="text-sm text-rp-neutral-400">{{ $activity['time'] }}</div>
                                <div class="flex flex-row items-center gap-2">
                                    <div class="text-rp-neutral-600">{{ $activity['employee_name'] }}</div>
                                    <div><x-icon.ellipse /></div>
                                    <div class="text-rp-neutral-400">{{ $activity['employee_role'] }}</div>
                                </div>
                                <div class="text-primary-600 text-sm">
                                    {!! $activity['title'] !!}
                                    @if (!empty($activity['attachment_url']))
                                        <a href="{{ $activity['attachment_url'] }}" class="underline" download
                                            target="_blank">
                                            {{ $activity['attachment_name'] }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
    @if ($cursor !== null)
        <x-button.filled-button class="!border" wire:click="loadCollections">Load More</x-button.filled-button>
    @endif
</div>
