<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class UsersTable extends BaseTable
{
    // Listen for events from the confirm modal
    protected $listeners = [
        'user.delete' => 'deleteUser',
        'user.activate' => 'activateUser',
        'user.suspend' => 'suspendUser',
    ];

    protected function query(): Builder
    {
        return User::query();
    }

    protected function headers(): array
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'email' => 'Email',
            'status' => 'Status',
            'created_at' => 'Created At',
            'actions' => 'Actions',
        ];
    }

    protected function sortableColumns(): array
    {
        return ['id', 'name', 'email', 'created_at'];
    }

    protected function columnRenderers(): array
    {
        return [
            // Clickable name
            'name' => function($row) {
                return sprintf(
                    '<a href="/users/%s" class="text-blue-600 hover:text-blue-900 font-medium">%s</a>',
                    $row->id,
                    e($row->name)
                );
            },

            // Status badge
            'status' => function($row) {
                $status = $row->status ?? 'active';
                $colors = [
                    'active' => 'bg-green-100 text-green-800',
                    'inactive' => 'bg-gray-100 text-gray-800',
                    'suspended' => 'bg-red-100 text-red-800',
                ];

                return sprintf(
                    '<span class="px-2 py-1 text-xs rounded-full %s">%s</span>',
                    $colors[$status] ?? 'bg-gray-100 text-gray-800',
                    ucfirst($status)
                );
            },

            // Actions with confirm modal
            // Actions with confirm modal
'actions' => function($row) {
    $status = $row->status ?? 'active';

    return sprintf(
        '<div class="flex items-center space-x-2">
            <!-- Edit button -->
            <button
                wire:click="editUser(%s)"
                class="text-blue-600 hover:text-blue-900"
                title="Edit">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
            </button>

            %s

            %s

            <!-- Delete button -->
            <button
                x-data
                x-on:click="
                    confirmAction({
                        title: \'Delete User\',
                        message: \'Are you sure you want to delete %s? This action cannot be undone.\',
                        type: \'danger\',
                        confirmText: \'Delete\'
                    }).then(confirmed => {
                        if (confirmed) {
                            Livewire.dispatch(\'user.delete\', [%s]);
                        }
                    })
                "
                class="text-red-600 hover:text-red-900"
                title="Delete">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
            </button>
        </div>',
        $row->id,
        // Activate button
        $status !== 'active' ? sprintf(
            '<button
                x-data
                x-on:click="
                    confirmAction({
                        title: \'Activate User\',
                        message: \'Activate %s?\',
                        type: \'success\',
                        confirmText: \'Activate\'
                    }).then(confirmed => {
                        if (confirmed) {
                            Livewire.dispatch(\'user.activate\', [%s]);
                        }
                    })
                "
                class="text-green-600 hover:text-green-900"
                title="Activate">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </button>',
            e($row->name),
            $row->id
        ) : '',
        // Suspend button
        $status === 'active' ? sprintf(
            '<button
                x-data
                x-on:click="
                    confirmAction({
                        title: \'Suspend User\',
                        message: \'Suspend %s? They will not be able to access the system.\',
                        type: \'warning\',
                        confirmText: \'Suspend\'
                    }).then(confirmed => {
                        if (confirmed) {
                            Livewire.dispatch(\'user.suspend\', [%s]);
                        }
                    })
                "
                class="text-yellow-600 hover:text-yellow-900"
                title="Suspend">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                </svg>
            </button>',
            e($row->name),
            $row->id
        ) : '',
        e($row->name),
        $row->id
    );
},

        ];
    }

    /**
     * Action methods - called after confirmation
     */

    // No confirmation needed
    public function editUser($userId)
    {
        return redirect()->route('users.edit', $userId);
    }

    // Called after delete confirmation
    public function deleteUser($userId)
    {
        User::findOrFail($userId)->delete();
        session()->flash('message', 'User deleted successfully.');
    }

    // Called after activate confirmation
    public function activateUser($userId)
    {
        User::findOrFail($userId)->update(['status' => 'active']);
        session()->flash('message', 'User activated successfully.');
    }

    // Called after suspend confirmation
    public function suspendUser($userId)
    {
        User::findOrFail($userId)->update(['status' => 'suspended']);
        session()->flash('message', 'User suspended successfully.');
    }
}
