<?php

namespace App\Contracts\Table;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

interface TableDataSource
{
    public function getQuery(): Builder;

    public function getPaginated(int $perPage, array $options = []): LengthAwarePaginator;

    public function getAll(array $options = []): Collection;

    public function count(array $options = []): int;

    public function applySearch(string $search, array $searchableFields): void;

    public function applyFilters(array $filters): void;

    public function applySorting(string $field, string $direction): void;
}
