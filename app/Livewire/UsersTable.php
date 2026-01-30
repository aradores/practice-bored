<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class UsersTable extends BaseTable
{
    public int $paginationLinks = 3;

    // Confirm modal listeners
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

    protected function searchableColumns(): array
    {
        return ['name', 'email'];
    }

    protected function columnRenderers(): array
    {
        return [
            'name' => fn ($row) => sprintf(
                '<a href="/users/%s" class="text-blue-600 hover:text-blue-900 font-medium">%s</a>',
                $row->id,
                e($row->name)
            ),
            'status' => fn ($row) => sprintf(
                '<span class="px-2 py-1 text-xs rounded-full %s">%s</span>',
                match ($row->status ?? 'active') {
                    'active' => 'bg-green-100 text-green-800',
                    'inactive' => 'bg-gray-100 text-gray-800',
                    'suspended' => 'bg-red-100 text-red-800',
                    default => 'bg-gray-100 text-gray-800',
                },
                ucfirst($row->status ?? 'active')
            ),
            'actions' => fn ($row) => view('tables.users.actions', compact('row'))->render(),
        ];
    }

    public function handleFilters(array $filters = [])
    {

        if (! empty($filters)) {
            $this->filters = array_merge($this->filters ?? [], $filters);
            $this->resetPage();
        }
    }

    /**
     * Optional: Render filters for inline UI (if needed)
     */
    public function renderFilters(): string
    {
        return view('livewire.partials.users-table-filters', [
            'statusFilter' => $this->filters['status'] ?? '',
            'dateFrom' => $this->filters['dateFrom'] ?? '',
            'dateTo' => $this->filters['dateTo'] ?? '',
            'search' => $this->filters['search'] ?? '',
            'perPage' => $this->perPage,
        ])->render();
    }

    /**
     * Apply additional filters to the query
     */
    protected function applyFilters(Builder $query): Builder
    {
        $query = parent::applyFilters($query);

        if (! empty($this->filters['dateFrom'] ?? '')) {
            $query->whereDate('created_at', '>=', $this->filters['dateFrom']);
        }

        if (! empty($this->filters['dateTo'] ?? '')) {
            $query->whereDate('created_at', '<=', $this->filters['dateTo']);
        }

        return $query;
    }

    // CRUD actions
    public function editUser($userId)
    {
        return redirect()->route('users.edit', $userId);
    }

    public function deleteUser($userId)
    {
        User::findOrFail($userId)->delete();
        session()->flash('message', 'User deleted successfully.');
    }

    public function activateUser($userId)
    {
        User::findOrFail($userId)->update(['status' => 'active']);
        session()->flash('message', 'User activated successfully.');
    }

    public function suspendUser($userId)
    {
        User::findOrFail($userId)->update(['status' => 'suspended']);
        session()->flash('message', 'User suspended successfully.');
    }
}
