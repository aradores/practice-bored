<?php

namespace App\Http\Livewire;

use App\Contracts\Table\TableColumn;
use App\Contracts\Table\TableDataSource;
use App\Contracts\Table\TableFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\WithPagination;

class PowerTable extends Component
{
    use WithPagination;

    // Configuration
    public $dataSource;

    public $columns = [];

    public $filters = [];

    public $actions = [];

    public $bulkActions = [];

    // Settings
    public $perPage = 25;

    public $perPageOptions = [10, 25, 50, 100, 250, 500];

    public $withPagination = true;

    public $withSearch = true;

    public $withFilters = true;

    public $withBulkActions = false;

    public $cacheTime = 300; // 5 minutes cache for expensive queries

    public $debounceTime = 500;

    public $lazyLoad = false;

    public $virtualScroll = false;

    public $rowHeight = 50;

    public $buffer = 20;

    // State
    public $search = '';

    public $sortField = 'id';

    public $sortDirection = 'asc';

    public $activeFilters = [];

    public $selectedRows = [];

    public $selectAll = false;

    public $showFilters = false;

    public $totalCount = 0;

    public $visibleRows = 0;

    public $loading = false;

    public $error = null;

    // Performance tracking
    public $queryTime = 0;

    public $memoryUsage = 0;

    // Custom slots/components
    public $headerSlot = null;

    public $footerSlot = null;

    public $emptyStateSlot = null;

    public $loadingSlot = null;

    public $rowSlot = null;

    // Query string for state persistence
    protected $queryString = [
        'search' => ['except' => '', 'as' => 'q'],
        'sortField' => ['except' => 'id'],
        'sortDirection' => ['except' => 'asc'],
        'page' => ['except' => 1],
        'perPage' => ['except' => 25],
        'activeFilters' => ['except' => []],
    ];

    protected $listeners = [
        'filterUpdated' => 'onFilterUpdated',
        'refreshTable' => 'refresh',
        'rowAction' => 'handleRowAction',
        'bulkAction' => 'handleBulkAction',
    ];

    public function mount(
        $dataSource,
        array $columns = [],
        array $filters = [],
        array $actions = [],
        array $settings = []
    ) {
        $startTime = microtime(true);

        // Handle data source - can be Model class, Builder, Collection, or custom DataSource
        $this->initializeDataSource($dataSource);

        // Initialize columns
        $this->columns = $this->normalizeColumns($columns);

        // Initialize filters
        $this->filters = $this->normalizeFilters($filters);

        // Initialize actions
        $this->actions = $actions;

        // Apply settings
        $this->applySettings($settings);

        // Initialize state from URL or defaults
        $this->initializeState();

        $this->queryTime = microtime(true) - $startTime;
        $this->memoryUsage = memory_get_usage(true);
    }

    protected function initializeDataSource($dataSource)
    {
        if ($dataSource instanceof TableDataSource) {
            $this->dataSource = $dataSource;
        } elseif (is_string($dataSource) && class_exists($dataSource)) {
            // Eloquent Model
            $this->dataSource = new class($dataSource) implements TableDataSource
            {
                private $model;

                private $query;

                public function __construct($modelClass)
                {
                    $this->model = app($modelClass);
                    $this->query = $this->model->query();
                }

                public function getQuery(): Builder
                {
                    return $this->query;
                }

                public function getPaginated(int $perPage, array $options = []): LengthAwarePaginator
                {
                    return $this->query->paginate($perPage);
                }

                public function getAll(array $options = []): Collection
                {
                    return $this->query->get();
                }

                public function count(array $options = []): int
                {
                    return $this->query->count();
                }

                public function applySearch(string $search, array $searchableFields): void
                {
                    if (! empty($search) && ! empty($searchableFields)) {
                        $this->query->where(function ($q) use ($search, $searchableFields) {
                            foreach ($searchableFields as $field) {
                                if (str_contains($field, '.')) {
                                    [$relation, $column] = explode('.', $field, 2);
                                    $q->orWhereHas($relation, function ($q2) use ($column, $search) {
                                        $q2->where($column, 'like', "%{$search}%");
                                    });
                                } else {
                                    $q->orWhere($field, 'like', "%{$search}%");
                                }
                            }
                        });
                    }
                }

                public function applyFilters(array $filters): void
                {
                    foreach ($filters as $filterName => $filterValue) {
                        if (! empty($filterValue)) {
                            // Handle nested filters (e.g., date ranges)
                            if (is_array($filterValue)) {
                                foreach ($filterValue as $key => $value) {
                                    if (! empty($value)) {
                                        $this->query->where($filterName.'.'.$key, $value);
                                    }
                                }
                            } else {
                                $this->query->where($filterName, $filterValue);
                            }
                        }
                    }
                }

                public function applySorting(string $field, string $direction): void
                {
                    $this->query->orderBy($field, $direction);
                }
            };
        } elseif ($dataSource instanceof Builder) {
            // Eloquent Query Builder
            $this->dataSource = new class($dataSource) implements TableDataSource
            {
                private $query;

                public function __construct(Builder $query)
                {
                    $this->query = $query;
                }

                // Implement all interface methods...
            };
        } else {
            throw new \InvalidArgumentException('Invalid data source provided');
        }
    }

    protected function normalizeColumns(array $columns): array
    {
        return array_map(function ($column) {
            if ($column instanceof TableColumn) {
                return $column;
            }

            return new class($column) implements TableColumn
            {
                private $config;

                public function __construct($config)
                {
                    $this->config = is_array($config) ? $config : ['name' => $config];
                }

                public function getName(): string
                {
                    return $this->config['name'] ?? $this->config['field'] ?? 'unknown';
                }

                public function getLabel(): string
                {
                    return $this->config['label'] ?? ucfirst(str_replace('_', ' ', $this->getName()));
                }

                public function isSortable(): bool
                {
                    return $this->config['sortable'] ?? true;
                }

                public function getComponent(): ?string
                {
                    return $this->config['component'] ?? null;
                }

                public function getValue($row)
                {
                    $name = $this->getName();

                    if (isset($this->config['value'])) {
                        return value($this->config['value'], $row);
                    }

                    if (isset($this->config['accessor'])) {
                        return data_get($row, $this->config['accessor']);
                    }

                    return data_get($row, $name);
                }

                public function format($value)
                {
                    if (isset($this->config['format'])) {
                        if (is_callable($this->config['format'])) {
                            return $this->config['format']($value);
                        }

                        switch ($this->config['format']) {
                            case 'date':
                                return $value ? $value->format('Y-m-d') : '';
                            case 'datetime':
                                return $value ? $value->format('Y-m-d H:i') : '';
                            case 'currency':
                                return number_format($value, 2);
                            case 'boolean':
                                return $value ? 'Yes' : 'No';
                            default:
                                return $value;
                        }
                    }

                    return $value;
                }

                public function getAttributes(): array
                {
                    return $this->config['attributes'] ?? [];
                }
            };
        }, $columns);
    }

    protected function normalizeFilters(array $filters): array
    {
        return array_map(function ($filter, $key) {
            if ($filter instanceof TableFilter) {
                return $filter;
            }

            return new class($key, $filter) implements TableFilter
            {
                private $name;

                private $config;

                public function __construct($name, $config)
                {
                    $this->name = $name;
                    $this->config = $config;
                }

                public function getName(): string
                {
                    return $this->name;
                }

                public function getLabel(): string
                {
                    return $this->config['label'] ?? ucfirst(str_replace('_', ' ', $this->name));
                }

                public function getType(): string
                {
                    return $this->config['type'] ?? 'text';
                }

                public function getComponent(): ?string
                {
                    return $this->config['component'] ?? null;
                }

                public function getOptions(): array
                {
                    if (isset($this->config['options'])) {
                        if (is_callable($this->config['options'])) {
                            return $this->config['options']();
                        }

                        return $this->config['options'];
                    }

                    return [];
                }

                public function apply($query, $value): void
                {
                    if (isset($this->config['apply']) && is_callable($this->config['apply'])) {
                        $this->config['apply']($query, $value);

                        return;
                    }

                    if (! empty($value)) {
                        $query->where($this->name, $value);
                    }
                }

                public function validate($value): bool
                {
                    if (isset($this->config['validate']) && is_callable($this->config['validate'])) {
                        return $this->config['validate']($value);
                    }

                    return true;
                }
            };
        }, $filters, array_keys($filters));
    }

    protected function applySettings(array $settings): void
    {
        foreach ($settings as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    protected function initializeState(): void
    {
        // Initialize filters from URL or defaults
        foreach ($this->filters as $filter) {
            if (! isset($this->activeFilters[$filter->getName()])) {
                $this->activeFilters[$filter->getName()] = $filter->getOptions()['default'] ?? '';
            }
        }
    }

    // Optimized query with caching for expensive operations
    protected function getRows()
    {
        $startTime = microtime(true);

        try {
            $cacheKey = $this->getCacheKey();

            if ($this->cacheTime > 0) {
                $cached = cache()->get($cacheKey);
                if ($cached && ! $this->shouldBustCache()) {
                    $this->queryTime = microtime(true) - $startTime;

                    return $cached;
                }
            }

            $query = $this->dataSource->getQuery();

            // Clone query for count to avoid affecting pagination
            $countQuery = clone $query;
            $this->totalCount = $countQuery->count();

            // Apply search
            if ($this->withSearch && ! empty($this->search)) {
                $searchableFields = array_map(fn ($col) => $col->getName(),
                    array_filter($this->columns, fn ($col) => $col->isSortable()));
                $this->dataSource->applySearch($this->search, $searchableFields);
            }

            // Apply filters
            foreach ($this->activeFilters as $filterName => $filterValue) {
                if (isset($this->filters[$filterName]) && ! empty($filterValue)) {
                    $this->filters[$filterName]->apply($query, $filterValue);
                }
            }

            // Apply sorting
            $this->dataSource->applySorting($this->sortField, $this->sortDirection);

            // Get results
            if ($this->withPagination) {
                $results = $this->dataSource->getPaginated($this->perPage);
            } else {
                $results = $this->dataSource->getAll();
            }

            $this->visibleRows = $results->count();

            if ($this->cacheTime > 0) {
                cache()->put($cacheKey, $results, $this->cacheTime);
            }

            $this->queryTime = microtime(true) - $startTime;

            return $results;

        } catch (\Exception $e) {
            $this->error = $e->getMessage();
            $this->loading = false;

            return $this->withPagination
                ? new LengthAwarePaginator([], 0, $this->perPage)
                : collect();
        }
    }

    protected function getCacheKey(): string
    {
        return 'table:'.md5(serialize([
            get_class($this->dataSource),
            $this->search,
            $this->sortField,
            $this->sortDirection,
            $this->activeFilters,
            $this->page,
            $this->perPage,
        ]));
    }

    protected function shouldBustCache(): bool
    {
        return request()->has('refresh') || $this->loading;
    }

    public function sortBy($field)
    {
        if (! $this->isColumnSortable($field)) {
            return;
        }

        $this->sortDirection = $this->sortField === $field
            ? ($this->sortDirection === 'asc' ? 'desc' : 'asc')
            : 'asc';

        $this->sortField = $field;
        $this->resetPage();
    }

    public function isColumnSortable($field): bool
    {
        foreach ($this->columns as $column) {
            if ($column->getName() === $field && $column->isSortable()) {
                return true;
            }
        }

        return false;
    }

    public function applyFilters()
    {
        // Validate all filters before applying
        foreach ($this->activeFilters as $filterName => $filterValue) {
            if (isset($this->filters[$filterName])) {
                if (! $this->filters[$filterName]->validate($filterValue)) {
                    $this->addError('activeFilters.'.$filterName, 'Invalid filter value');

                    return;
                }
            }
        }

        $this->resetPage();
        $this->showFilters = false;
        $this->refresh();
    }

    public function resetFilters()
    {
        $this->activeFilters = [];
        $this->search = '';
        $this->resetPage();
        $this->refresh();
    }

    public function onFilterUpdated($filterName, $value)
    {
        $this->activeFilters[$filterName] = $value;
        $this->resetPage();
    }

    public function refresh()
    {
        $this->loading = true;
        cache()->forget($this->getCacheKey());
        $this->getRows();
        $this->loading = false;
    }

    public function selectAllRows()
    {
        if ($this->selectAll) {
            $rows = $this->getRows();
            $this->selectedRows = $rows->pluck('id')->toArray();
        } else {
            $this->selectedRows = [];
        }
    }

    public function handleRowAction($action, $rowId)
    {
        if (isset($this->actions[$action]) && is_callable($this->actions[$action])) {
            $row = $this->getRows()->firstWhere('id', $rowId);
            $this->actions[$action]($row);
        }
    }

    public function handleBulkAction($action)
    {
        if (isset($this->bulkActions[$action]) && is_callable($this->bulkActions[$action])) {
            $this->bulkActions[$action]($this->selectedRows);
            $this->selectedRows = [];
            $this->selectAll = false;
            $this->refresh();
        }
    }

    public function updatedSearch()
    {
        $this->resetPage();
        if ($this->debounceTime > 0) {
            $this->dispatchBrowserEvent('search-debounced');
        }
    }

    public function updatedPerPage()
    {
        $this->resetPage();
        $this->refresh();
    }

    public function render()
    {
        return view('livewire.power-table', [
            'rows' => $this->getRows(),
            'columns' => $this->columns,
            'filters' => $this->filters,
            'isLoading' => $this->loading,
        ]);
    }
}
