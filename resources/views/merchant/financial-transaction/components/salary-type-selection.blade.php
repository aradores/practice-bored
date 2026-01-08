{{-- 
    Use: <livewire:merchant.financial-transaction.components.salary-type-selection wire:model.live="parent_property" />
--}}

<div class="absolute mt-1 right-0 w-96 rounded-lg shadow-md p-4 bg-white text-rp-neutral-700 flex flex-col gap-2 z-20">
    @foreach ($this->salary_types as $salary_type)
        <label class="w-full flex items-center gap-2 p-3">
            <input type="checkbox" class="form-checkbox w-5 h-5 text-rp-red-500" wire:model="selected_salary_type_slugs"
                name="{{ $salary_type['slug'] }}" value="{{ $salary_type['slug'] }}" id="{{ $salary_type['slug'] }}" />
            <p>{{ $salary_type['name'] }}</p>
        </label>
    @endforeach
</div>