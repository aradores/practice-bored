<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class UsersTable extends BaseTable
{
    public string $statusFilter = '';

    public string $dateFrom = '';

    public string $dateTo = '';

    public int $paginationLinks = 3; // Will show: ... 7 8 9 [10] 11 12 13 ...

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
            'name' => function ($row) {
                return sprintf(
                    '<a href="/users/%s" class="text-blue-600 hover:text-blue-900 font-medium">%s</a>',

                    $row->id,
                    e($row->name)
                );

            },

            // Status badge
            'status' => function ($row) {
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

            'actions' => fn ($row) => view('tables.users.actions', compact('row'))->render(),

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

    /**
     * Render custom filters for this table
     * This method is called by the base-table.blade.php view
     */
    public function renderFilters(): string
    {
        return view('livewire.partials.users-table-filters', [
            'statusFilter' => $this->statusFilter,
            'dateFrom' => $this->dateFrom,
            'dateTo' => $this->dateTo,
            'search' => $this->search,
            'perPage' => $this->perPage,
        ])->render();
    }

    // These updatedX methods reset pagination when filters change
    public function updatedStatusFilter()
    {
        $this->resetPage();
    }

    public function updatedDateFrom()
    {
        $this->resetPage();
    }

    public function updatedDateTo()
    {
        $this->resetPage();
    }

    protected function searchableColumns(): array
    {
        return ['name', 'email'];
    }

    protected function applySearch(Builder $query): Builder
    {
        if (empty($this->search)) {
            return $query;
        }

        return $query->where(function ($q) {
            $q->where('name', 'like', "%{$this->search}%")
                ->orWhere('email', 'like', "%{$this->search}%");
        });
    }

    protected function applyFilters(Builder $query): Builder
    {
        $query = parent::applyFilters($query);

        if (! empty($this->statusFilter)) {
            $query->where('status', $this->statusFilter);
        }

        if (! empty($this->dateFrom)) {
            $query->whereDate('created_at', '>=', $this->dateFrom);
        }

        if (! empty($this->dateTo)) {
            $query->whereDate('created_at', '<=', $this->dateTo);
        }

        return $query;
    }
}
