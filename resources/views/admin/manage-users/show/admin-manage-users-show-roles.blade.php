<x-main.content class="!px-16 !py-10" x-data="{
    attachModal: $wire.entangle('attach_modal'),
    detachModal: $wire.entangle('detach_modal'),
    detachRole: '',
    detachName: '',
}">
    <livewire:components.layout.admin.user-details-header :user="$user" />

    <x-table.standard class=" mt-6">
        <x-slot:table_header>
            <x-table.standard.th class="w-52 min-w-52 max-w-52">
                Admin Roles
            </x-table.standard.th>
            <x-table.standard.th class="w-56 min-w-56 max-w-56 text-end">
                <x-button.filled-button color="primary" @click="attachModal=true;" class="!w-24">
                    ADD ROLE
                </x-button.filled-button>
            </x-table.standard.th>
        </x-slot:table_header>
        <x-slot:table_data>
            @foreach ($this->current_roles() as $slug => $name)
                <x-table.standard.row wire:key="role-{{ $slug }}">
                    <x-table.standard.td class="w-56 min-w-56 max-w-56">
                        {{ $name }}
                    </x-table.standard.td>
                    <x-table.standard.td class="w-56 min-w-56 max-w-56 text-end">
                        @if (auth()->id() == 1 || $slug != 'admin')
                            <x-button.filled-button color="danger"
                                @click="detachModal=true;detachRole='{{ $slug }}';detachName='{{ $name }}'"
                                class="!w-24 !p-2">
                                REMOVE
                            </x-button.filled-button>
                        @endif
                    </x-table.standard.td>
                </x-table.standard.row>
            @endforeach
        </x-slot:table_data>
    </x-table.standard>

    <x-modal x-model="attachModal">
        <x-modal.confirmation-modal title="Attach Role">
            <x-slot:message>
                Select admin role to be added
            </x-slot:message>
            <x-slot:additional_contents>
                <select name="admin-roles" id="admin-roles" class="w-full border-2 border-black rounded-md p-2"
                    wire:model='selected_role'>
                    <option value="" hidden>Select Role</option>
                    @foreach ($this->roles as $slug => $name)
                        @if (in_array($name, $this->current_roles) == false)
                            <option value="{{ $slug }}">{{ $name }}</option>
                        @endif
                    @endforeach
                </select>
                @error('selected_role')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </x-slot:additional_contents>
            <x-slot:action_buttons>
                <x-button.outline-button wire:target='add_role' wire:loading.attr='disabled'
                    wire:loading.class='cursor-progress' @click="attachModal=false;" color="primary" class="w-1/2">
                    CANCEL
                </x-button.outline-button>
                <x-button.filled-button wire:target='add_role' wire:loading.attr='disabled'
                    wire:loading.class='cursor-progress' wire:click='add_role' color="primary" class="w-1/2">
                    ADD
                </x-button.filled-button>
            </x-slot:action_buttons>
        </x-modal.confirmation-modal>
    </x-modal>

    <x-modal x-model="detachModal">
        <x-modal.confirmation-modal title="Detach Role">
            <x-slot:message>
                Are you sure you would like to remove <span x-text="detachName" class="font-bold"></span> from this
                user?
            </x-slot:message>
            <x-slot:action_buttons>
                <x-button.outline-button wire:target='remove_role' wire:loading.attr='disabled'
                    wire:loading.class='cursor-progress' @click="detachModal=false;detachRole='';detachName=''"
                    color="primary" class="w-1/2">
                    CANCEL
                </x-button.outline-button>
                <x-button.filled-button wire:target='remove_role' wire:loading.attr='disabled'
                    wire:loading.class='cursor-progress'
                    @click="$wire.remove_role(detachRole);detachRole='';detachName=''" color="primary" class="w-1/2">
                    CONFIRM
                </x-button.filled-button>
            </x-slot:action_buttons>
        </x-modal.confirmation-modal>
    </x-modal>

    {{-- Toast Notification --}}
    @if (session()->has('success'))
        <x-toasts.success />
    @endif

    @if (session()->has('error'))
        <x-toasts.error />
    @endif
</x-main.content>
