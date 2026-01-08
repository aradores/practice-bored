<div class="w-full grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
    @forelse ($data as $key => $item)
         <livewire:admin.components.manage-fees.kpi-chart-card 
            :wire:key="'kpi-wire-key-' . $key . '-' . uniqid('kpi_')"
            title="{{ $item['title'] }}"
            tooltip="{{ $item['tooltip'] }}"
            chartId="kpi-chart-id-{{ $key }}"
            total="{{ $item['total'] }}"
            previous="{{ $item['previous'] }}"
            percentageDifferential="{{ $item['percentage'] }}"
            :labels=" $item['labels']"
            :chart-data="$item['values']" />
    @empty
        
    @endforelse
</div>