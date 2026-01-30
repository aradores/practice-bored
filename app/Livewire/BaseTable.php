<?php

namespace App\Livewire;

use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

abstract class BaseTable extends Component
{
    use WithPagination;

    // Unified filters array (search is part of this)
    public array $filters = [];

    public string $sortField = '';
    public string $sortDirection = 'asc';

    public int $perPage = 10;
    public int $paginationLinks = 5;

    // Listeners for external events
    protected $listeners = [
        'sortUpdated' => 'handleSort',
    ];

    /**
     * Query builder for the table
     */
    abstract protected function query(): Builder;

    /**
     * Table headers
     */
    abstract protected function headers(): array;

    /**
     * Sortable columns
     */
    protected function sortableColumns(): array
    {
        return array_keys($this->headers());
    }

    /**
     * Searchable columns
     */
    protected function searchableColumns(): array
    {
        return array_keys($this->headers());
    }

    /**
     * Apply search filter
     */
    protected function applySearch(Builder $query): Builder
    {
        $search = $this->filters['search'] ?? null;

        if (empty($search)) {
            return $query;
        }

        return $query->where(function ($q) use ($search) {
            foreach ($this->searchableColumns() as $column) {
                $q->orWhere($column, 'like', "%{$search}%");
            }
        });
    }

    /**
     * Apply all other filters
     */
    protected function applyFilters(Builder $query): Builder
    {
        foreach ($this->filters as $field => $value) {
            if ($field === 'search' || empty($value)) continue;

            if (is_array($value)) {
                $query->whereIn($field, $value);
            } else {
                $query->where($field, $value);
            }
        }

        return $query;
    }

    /**
     * Apply sorting
     */
    protected function applySort(Builder $query): Builder
    {
        if (!empty($this->sortField) && in_array($this->sortField, $this->sortableColumns())) {
            $query->orderBy($this->sortField, $this->sortDirection);
        }

        return $query;
    }

    /**
     * Get final paginated data
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
     * Public method to update filters from external components
     */
    public function handleFilters(array $filters)
    {
        $this->filters = array_merge($this->filters, $filters);
        $this->resetPage();
    }

    /**
     * Public method to update sorting
     */
    public function handleSort(string $field)
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
     * Sort toggle from column header
     */
    public function sortBy(string $field)
    {
        $this->handleSort($field);
    }

    /**
     * Update per page
     */
    public function updatedPerPage()
    {
        $this->resetPage();
    }

    /**
     * Column renderers
     */
    protected function columnRenderers(): array
    {
        return [];
    }

    protected function hasCustomRenderer(string $column): bool
    {
        return isset($this->columnRenderers()[$column]);
    }

    protected function renderColumn($row, string $column)
    {
        $renderers = $this->columnRenderers();
        if (isset($renderers[$column])) {
            return $renderers[$column]($row, $column);
        }

        return data_get($row, $column);
    }

    public function render()
    {
        return view('livewire.base-table', [
            'data' => $this->getData(),
            'headers' => $this->headers(),
            'sortableColumns' => $this->sortableColumns(),
            'paginationLinks' => $this->paginationLinks,
        ]);
    }
}

