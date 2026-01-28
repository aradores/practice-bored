<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class UsersTable extends BaseTable
{
    // Add your filter properties here
    public string $statusFilter = '';
    public string $dateFrom = '';
    public string $dateTo = '';

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
            'created_at' => 'Created At',
        ];
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

        return $query->where(function($q) {
            $q->where('name', 'like', "%{$this->search}%")
              ->orWhere('email', 'like', "%{$this->search}%");
        });
    }

    protected function applyFilters(Builder $query): Builder
    {
        $query = parent::applyFilters($query);

        if (!empty($this->statusFilter)) {
            $query->where('status', $this->statusFilter);
        }

        if (!empty($this->dateFrom)) {
            $query->whereDate('created_at', '>=', $this->dateFrom);
        }

        if (!empty($this->dateTo)) {
            $query->whereDate('created_at', '<=', $this->dateTo);
        }

        return $query;
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
}
