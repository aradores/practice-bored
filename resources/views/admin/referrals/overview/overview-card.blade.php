<div class="bg-white flex flex-col justify-between px-6 py-4 rounded-2xl w-full">
    <div class="flex flex-row items-center justify-between">
        <div class="flex gap-2 items-center">
            <div x-data="tooltip" class="relative cursor-pointer" @mouseover="open" @mouseleave="close">
                <div>
                    <x-icon.info />
                </div>
                {{-- Tooltip --}}
                <div x-cloak x-show="isOpen"
                    class="absolute w-72 max-w-72 bottom-[125%] left-[-50%]  rounded-md px-2 py-1 bg-rp-neutral-700 text-white font-light text-sm">
                    <span>{{ $tooltip_text }}</span>
                    <!-- Tail -->
                    <div
                        class="absolute top-full left-4 -translate-x-1/2 w-0 h-0 
                        border-l-8 border-l-transparent 
                        border-r-8 border-r-transparent 
                        border-t-8 border-rp-neutral-700">
                    </div>
                </div>
            </div>
            <span>{{ $title }}</span>
        </div>

        @if ($vs_value > $value and $vs_value !== 0)
            <span
                class="flex items-center justify-center w-max px-2 py-1 border border-rp-red-600 bg-rp-red-200 text-rp-red-600 rounded-md">
                <span>
                    <x-icon.solid-arrow-down fill="#dc2626" />
                </span>
                <span>{{ round(abs((($value - $vs_value) / $vs_value) * 100), 2) }}%</span>
            </span>
        @elseif($value > $vs_value)
            <span
                class="flex items-center justify-center w-max px-2 py-1 border border-rp-green-600 bg-rp-green-200 text-rp-green-600 rounded-md">
                <span>
                    <x-icon.solid-arrow-up fill="#149d8c" />
                </span>
                @if ($vs_value == 0)
                    <span class="text-rp-green-600">100%</span>
                @else
                    <span class="text-rp-green-600">
                        {{ round(abs((($value - $vs_value) / $vs_value) * 100), 2) }}%</span>
                @endif
            </span>
        @elseif($value === $vs_value and $value !== 0)
            {{-- No --}}
            <span
                class="flex items-center justify-center w-8 px-2 py-1 border border-rp-yellow-600 bg-rp-yellow-200 text-rp-yellow-600 rounded-md">
                <span>...</span>
            </span>
        @elseif($value !== $vs_value and $vs_value === 0)
            {{-- -100% --}}
            <span
                class="flex items-center justify-center w-max px-2 py-1 border border-rp-red-600 bg-rp-red-200 text-rp-red-600 rounded-md">
                <span>
                    <x-icon.solid-arrow-down fill="#dc2626" />
                </span>
                <span>100%</span>
            </span>
        @endif
    </div>
    <div>
        <h2 class="text-primary-600 font-bold text-[32px]">
            @isset($is_percentage)
                {{ $value . '%' }}
            @else
                {{ $value }}
            @endisset
        </h2>

        <span>
            vs. @isset($is_percentage)
                {{ $vs_value . '%' }}
            @else
                {{ $vs_value }}
            @endisset
            previous month
        </span>

        {{-- Chart --}}
        <livewire:charts.livewire-line-chart :title="$chart_title" :labels="$chart_labels" :data="$chart_data" />
    </div>
</div>

@script
    <script>
        Alpine.data('tooltip', () => ({
            isOpen: false,
            open() {
                this.isOpen = true;
            },
            close() {
                this.isOpen = false;
            },
        }));
    </script>
@endscript
