<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Builder;

abstract class BaseTable extends Component
{
    use WithPagination;

    // Listening properties
    public string $search = '';
    public string $sortField = '';
    public string $sortDirection = 'asc';
    public array $filters = [];

    // Pagination
    public int $perPage = 10;

    protected $listeners = [
        'searchUpdated' => 'handleSearch',
        'sortUpdated' => 'handleSort',
        'filtersUpdated' => 'handleFilters',
    ];

    /**
     * Define the query builder for the table
     */
    abstract protected function query(): Builder;

    /**
     * Define table headers
     * Format: ['column_name' => 'Display Label', ...]
     */
    abstract protected function headers(): array;

    /**
     * Define which columns are sortable
     */
    protected function sortableColumns(): array
    {
        return array_keys($this->headers());
    }

    /**
     * Apply search logic to the query
     */
    protected function applySearch(Builder $query): Builder
    {
        if (empty($this->search)) {
            return $query;
        }

        // Override this method in child classes for custom search logic
        return $query->where(function($q) {
            foreach ($this->searchableColumns() as $column) {
                $q->orWhere($column, 'like', "%{$this->search}%");
            }
        });
    }

    /**
     * Define searchable columns
     */
    protected function searchableColumns(): array
    {
        return array_keys($this->headers());
    }

    /**
     * Apply filters to the query
     */
    protected function applyFilters(Builder $query): Builder
    {
        foreach ($this->filters as $field => $value) {
            if (!empty($value)) {
                $query->where($field, $value);
            }
        }

        return $query;
    }

    /**
     * Apply sorting to the query
     */
    protected function applySort(Builder $query): Builder
    {
        if (!empty($this->sortField) && in_array($this->sortField, $this->sortableColumns())) {
            $query->orderBy($this->sortField, $this->sortDirection);
        }

        return $query;
    }

    /**
     * Get the final data for the table
     */
    public function getData()
    {
        $query = $this->query();

        $query = $this->applySearch($query);
        $query = $this->applyFilters($query);
        $query = $this->applySort($query);

        return $query->paginate($this->perPage);
    }

    /**
     * Handle search events
     */
    public function handleSearch($search)
    {
        $this->search = $search;
        $this->resetPage();
    }

    /**
     * Handle sort events
     */
    public function handleSort($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }

        $this->resetPage();
    }

    /**
     * Handle filter events
     */
    public function handleFilters($filters)
    {
        $this->filters = $filters;
        $this->resetPage();
    }

    /**
     * Direct sort toggle from clicking column headers
     */
    public function sortBy($field)
    {
        $this->handleSort($field);
    }

    /**
     * Update search directly
     */
    public function updatedSearch()
    {
        $this->resetPage();
    }

    /**
     * Update per page
     */
    public function updatedPerPage()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.base-table', [
            'data' => $this->getData(),
            'headers' => $this->headers(),
            'sortableColumns' => $this->sortableColumns(),
        ]);
    }
}
