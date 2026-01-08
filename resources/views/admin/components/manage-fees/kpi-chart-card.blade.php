<div class="w-full bg-white rounded-xl border border-rp-neutral-400 px-4 py-8">
    <div class="details flex flex-col gap-1">
        <div class="flex flex-row items-center gap-1">
            <x-icon.hand-cash stroke="currentColor" />
            <p class="text-sm">{{ $title ?? '-' }}</p>
            @if(isset($tooltip))
                <div 
                    x-data="{ isOpen: false, open() { this.isOpen = true }, close() { this.isOpen = false } }"
                    class="relative cursor-pointer"
                    @mouseover="open"
                    @mouseleave="close">
                    <x-icon.info />
                    <div 
                        x-cloak 
                        x-show="isOpen"
                        class="z-10 absolute w-72 max-w-72 bottom-[125%] left-[-50%] rounded-md px-2 py-1 bg-rp-neutral-700 text-white font-light text-sm">
                        {{-- Tool tip desc --}}
                        <span>{{ $tooltip }}</span>
                        <div class="absolute top-full left-4 -translate-x-1/2 w-0 h-0 
                                    border-l-8 border-l-transparent 
                                    border-r-8 border-r-transparent 
                                    border-t-8 border-rp-neutral-700">
                        </div>
                    </div>
                </div>
            @endif
        </div>
        {{-- <p class="text-2xl font-bold">₱ {{ number_format($total, 2) ?? '-' }}</p> --}}
        <p class="text-2xl font-bold">{{ $total }}</p>
        
        {{-- <div class="flex justify-between" x-data="getPercentage({{ $total ?? 0 }}, {{ $previous ?? 0 }})"> --}}
            <div class="flex justify-between" x-data="{percentage: @entangle('percentageDifferential')}">
            {{-- <p class="text-sm text-rp-neutral-400">₱ {{ number_format($previous, 2) ?? '-' }} </p> --}}
            <p class="text-sm text-rp-neutral-400">{{ $previous }}</p>
            <span 
                class="flex"
                :class="percentage < 0 ? 'text-rp-red-600' : 'text-rp-green-600'">
                <template x-if="percentage >= 0">
                    <x-icon.solid-arrow-up class="text-rp-green-600" fill="currentColor" />
                </template>
                <template x-if="percentage < 0">
                    <x-icon.solid-arrow-down class="text-rp-red-600" fill="currentColor" />
                </template>
                <p><span class="text-sm" x-text="percentage"></span>%</p>
                {{-- <p class="text-sm">{{ $percentageDifferential ?? 0 }}</p> --}}
            </span>
        </div>
    </div>
    <div 
        x-data="cardChartComponent({
            chartId: '{{ $chartId ?? 'markupChart' }}',
            chartLabel: @json($labels ?? []),
            chartData: @json($chartData ?? [])
        })"
        x-init="$nextTick(() => renderChart())"
        class="{{ $class }} w-full h-full">

        <div class="relative max-h-52">
            <canvas :id="chartId"></canvas>
        </div>
    </div>
</div>



@push('scripts')
    <script>
        // document.addEventListener('alpine:init', () => {
        //     Alpine.data('getPercentage', (total = 0, previous = 0) => ({
        //         total,
        //         previous,
        //         get percentage() {
        //             if (this.previous === 0) return 0;
        //             const diff = ((this.total - this.previous) / Math.abs(this.previous)) * 100;
        //             return diff.toFixed(2);
        //         }
        //     }));
        // });


    function cardChartComponent({ chartId, chartData, chartLabel }) {
        return {
            chart: null,
            chartId: chartId,
            chartData: chartData,
            renderChart() {
                const canvas = document.getElementById(this.chartId);
                if (!canvas) return; 
                const ctx = canvas.getContext('2d');
                if (this.chart) this.chart.destroy();

                this.chart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        // labels: Array.from({ length: 16 }, (_, index) => index * 2 + 1),
                        labels: chartLabel,
                        datasets: [{
                            data: this.chartData.length ? this.chartData : [0],
                            borderColor: '#7F56D9',
                            backgroundColor: 'rgba(127, 86, 217, 1)',
                            tension: 0.4,
                            fill: false,
                            pointRadius: function(context) {
                                const index = context.dataIndex;
                                const data = context.dataset.data;
                                return index === data.length - 1 ? 4 : 1;
                            },
                            pointHoverRadius: function(context) {
                                const index = context.dataIndex;
                                const data = context.dataset.data;
                                return index === data.length - 1 ? 4 : 1;
                            },
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                            enabled: true,
                            callbacks: {
                                title: function() {
                                    return '';
                                },
                                label: function(context) {
                                    return context.raw;
                                }
                            }
                        }
                        },
                        scales: {
                            x: { 
                                grid: { 
                                    display: false 
                                },
                                ticks: {
                                            autoSkip: false,
                                            maxRotation: 0,
                                            minRotation: 0
                                        } 
                                    },
                            y: {
                                grid: { color: '#f0f0f0' },
                                beginAtZero: true,
                                ticks: {
                                    maxTicksLimit: 5
                                }
                            },
                        }
                    }
                });
            }
        }
    }
    </script>
@endpush
