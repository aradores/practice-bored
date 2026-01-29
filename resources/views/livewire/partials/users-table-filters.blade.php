{{-- resources/views/livewire/partials/users-table-filters.blade.php --}}

<div>
    <!-- Search -->
    <div>
        <input
            type="text"
            wire:model.live="search"
            placeholder="Search users..."
            class="w-full px-4 py-2 border rounded-lg"
        >
    </div>

    <!-- Filters -->
    <div class="flex gap-4">
        <select wire:model.live="statusFilter" class="px-4 py-2 border rounded-lg">
            <option value="">All Status</option>
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
        </select>

        <input
            type="date"
            wire:model.live="dateFrom"
            placeholder="From"
            class="px-4 py-2 border rounded-lg"
        >

        <input
            type="date"
            wire:model.live="dateTo"
            placeholder="To"
            class="px-4 py-2 border rounded-lg"
        >
    </div>

    <!-- Per Page -->
    <div>
        <select wire:model.live="perPage" class="px-4 py-2 border rounded-lg">
            <option value="10">10 per page</option>
            <option value="25">25 per page</option>
            <option value="50">50 per page</option>
            <option value="100">100 per page</option>
        </select>
    </div>
</div>
