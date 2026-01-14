<!-- resources/views/livewire/forms/user-form.blade.php -->
<div class="space-y-6">
    <h2 class="text-xl font-semibold">{{ $userId ? 'Edit User' : 'Create User' }}</h2>

    <form wire:submit.prevent="confirm">
        <!-- Name -->
        <div>
            <label>Full Name</label>
            <input type="text" wire:model="name" class="form-input">
            @error('name')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
        </div>

        <!-- Email -->
        <div>
            <label>Email Address</label>
            <input type="email" wire:model="email" class="form-input">
            @error('email')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
        </div>

        <!-- Password (conditional) -->
        @if(!$userId || $password)
        <div>
            <label>Password {{ $userId ? '(leave blank to keep current)' : '' }}</label>
            <input type="password" wire:model="password" class="form-input">
            @error('password')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
        </div>

        <div>
            <label>Confirm Password</label>
            <input type="password" wire:model="password_confirmation" class="form-input">
        </div>
        @endif

        <!-- Role -->
        <div>
            <label>Role</label>
            <select wire:model="role" class="form-select">
                <option value="user">User</option>
                <option value="editor">Editor</option>
                <option value="admin">Admin</option>
            </select>
            @error('role')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
        </div>

        <!-- Form Actions -->
        <div class="flex space-x-3">
            @if($hasChanges)
            <button type="button" wire:click="resetForm" class="btn-secondary">
                Reset
            </button>
            @endif

            <button type="submit" wire:loading.attr="disabled" class="btn-primary">
                {{ $userId ? 'Update' : 'Create' }}
            </button>
        </div>
    </form>
</div>
