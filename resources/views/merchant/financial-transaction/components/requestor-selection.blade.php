<div class="absolute mt-1 right-0 w-96 rounded-lg shadow-md p-4 bg-white text-rp-neutral-700 flex flex-col gap-2 z-20">
    <div class="flex justify-between items-start">
        <h2 class="font-semibold">{{ count($this->selected_requestor_ids) }} selected</h2>
        <x-button.outline-button color="red" wire:click="select_all_requestors" class="p-2.5 text-sm">Select
            All</x-button.outline-button>
    </div>

    <x-input.search icon_position="left" wire:model.live="search" placeholder="Search" />

    <div class="flex flex-col gap-2 max-h-64 overflow-y-auto">
        @foreach ($this->requestors as $requestor)
            <label class="flex items-center justify-between p-3 rounded-lg cursor-pointer hover:bg-gray-100 transition">
                <div class="flex items-center space-x-3">
                    <img src="{{ $requestor->profile_url }}" alt="Avatar" class="w-10 h-10 rounded-full" />
                    <div>
                        <p class="font-bold text-sm text-rp-neutral-500">{{ $requestor->full_name }}</p>
                        <p class="text-sm text-rp-neutral-600">{{ $requestor->phone_number }}</p>
                    </div>
                </div>
                <input type="checkbox" class="form-checkbox w-5 h-5 text-rp-red-500" value="{{ $requestor->id }}"
                    wire:model.live="selected_requestor_ids" />
            </label>
        @endforeach
    </div>

    <!-- Footer Buttons -->
    <div class="flex justify-end gap-2">
        <x-button.outline-button color="red" @click="$dispatch('closeModal{{ $event_id }}')"
            class="!p-2.5 text-sm !border">Cancel</x-button.outline-button>

        @if ($has_clear_button)
            <x-button.outline-button color="red" wire:click="clear_selection"
                class="!p-2.5 text-sm !border">Clear</x-button.outline-button>
        @endif

        <x-button.filled-button color="red" wire:click="apply_selection"
            class="!p-2.5 text-sm">Apply</x-button.filled-button>
    </div>
</div>
