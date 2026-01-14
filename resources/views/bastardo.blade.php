<!-- resources/views/admin/components/forms/bastardo.blade.php -->
<div>
    <form wire:submit.prevent="confirm">
        <div class="space-y-6">
            <!-- Name Field -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                    Name <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    id="name"
                    wire:model.blur="name"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror"
                    placeholder="Enter name"
                >
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email Field -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                    Email <span class="text-red-500">*</span>
                </label>
                <input
                    type="email"
                    id="email"
                    wire:model.blur="email"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror"
                    placeholder="Enter email"
                >
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description Field -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">
                    Description
                </label>
                <textarea
                    id="description"
                    wire:model.blur="description"
                    rows="4"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('description') border-red-500 @enderror"
                    placeholder="Enter description"
                ></textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end space-x-3">
                @if($hasChanges && $showResetFormButton)
                    <button
                        type="button"
                        wire:click="resetForm"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md transition"
                    >
                        Reset
                    </button>
                @endif

                <button
                    type="submit"
                    class="px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-md transition disabled:opacity-50"
                    wire:loading.attr="disabled"
                >
                    <span>Submit</span>
                    <!-- <span wire:loading>Processing...</span> -->
                </button>
            </div>
        </div>
    </form>

    <!-- Include the base form template (for confirmation modal and messages) -->
    @include('admin.components.forms.base-form')
</div>
