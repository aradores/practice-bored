@extends('admin.components.forms.base-form')

@section('form')
<div class="space-y-6">
    <div>
        <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
        <input wire:model="name" id="name" type="text"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
            placeholder="John Doe" />
        @error('name')
        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
        <input wire:model="email" id="email" type="email"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
            placeholder="john@example.com" />
        @error('email')
        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
        <input wire:model="password" id="password" type="password"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
            placeholder="••••••••" />
        @error('password')
        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
        <input wire:model="password_confirmation" id="password_confirmation" type="password"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
            placeholder="••••••••" />
        @error('password_confirmation')
        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Roles</label>
        <div class="mt-2 space-y-2">
            @foreach($availableRoles as $role)
            <label class="inline-flex items-center">
                <input type="checkbox" wire:model="roles" value="{{ $role->id }}"
                    class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                <span class="ml-2">{{ $role->name }}</span>
            </label>
            @endforeach
        </div>
        @error('roles')
        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex justify-end space-x-3">
        <button type="button" wire:click="resetForm" wire:loading.attr="disabled"
            class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 disabled:opacity-50"
            @disabled($isSubmitting || !$hasChanges)>
            Reset
        </button>

        <button type="button" wire:click="confirm" wire:loading.attr="disabled"
            class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50"
            @disabled($isSubmitting || !$hasChanges)>
            Create User
        </button>
    </div>
</div>
@endsection
