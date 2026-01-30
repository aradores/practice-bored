<div class="flex items-center space-x-2">
    <!-- Edit button example -->
    <button wire:click="editUser({{ $row->id }})"
        class="text-blue-600 hover:text-blue-900"
        title="Edit">
        ✏️
    </button>

    <!-- Delete button triggers modal -->

    <button
    wire:click="$dispatch('showConfirm', {
        title: 'Delete User',
        message: 'Are you sure you want to delete {{ $row->name }}?',
        event: 'user.delete',
        params: [{{ $row->id }}],
        confirmText: 'Delete',
        confirmClass: 'bg-red-600 hover:bg-red-700'
    })"
    class="text-red-600 hover:text-red-900"
    title="Delete"
>
    🗑️
</button>

</div>

