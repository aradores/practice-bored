<div class="flex flex-col gap-3 text-neutral-700 mb-3">
    {{-- Record and page buttons --}}
    <div class="flex flex-row justify-between items-start">
        <div class="flex flex-row gap-2 items-center">
            <span>Show</span>
            <x-dropdown.select wire:model="per_page" wire:change="updateRecordsPerPage"
                class="text-left appearance-none !px-0 !py-0">
                <x-dropdown.select.option value="10">10</x-dropdown.select.option>
                <x-dropdown.select.option value="20">20</x-dropdown.select.option>
                <x-dropdown.select.option value="30">30</x-dropdown.select.option>
                <x-dropdown.select.option value="40">40</x-dropdown.select.option>
                <x-dropdown.select.option value="50">50</x-dropdown.select.option>
            </x-dropdown.select>
            <span>records</span>
        </div>
        @if ($this->transactions->hasPages())
            <div class="flex flex-row gap-2.5">
                <button wire:click="previousPage"
                    class="p-2 rounded-full {{ $this->transactions->onFirstPage() ? '' : 'hover:bg-rp-neutral-100' }}"
                    {{ $this->transactions->onFirstPage() ? 'disabled' : '' }}><x-icon.chevron-left
                        color="{{ $this->transactions->onFirstPage() ? '#D3DADE' : '#647887' }}" /></button>
                <button wire:click="nextPage"
                    class="p-2 rounded-full {{ $this->transactions->hasMorePages() ? 'hover:bg-rp-neutral-100' : '' }}"
                    {{ $this->transactions->hasMorePages() ? '' : 'disabled' }}><x-icon.chevron-right
                        color="{{ $this->transactions->hasMorePages() ? '#647887' : '#D3DADE
                        ' }}" /></button>
            </div>
        @endif
    </div>
</div>
