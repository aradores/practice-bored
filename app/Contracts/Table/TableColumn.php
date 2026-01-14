<?php

namespace App\Contracts\Table;

interface TableColumn
{
    public function getName(): string;

    public function getLabel(): string;

    public function isSortable(): bool;

    public function getComponent(): ?string;

    public function getValue($row);

    public function format($value);

    public function getAttributes(): array;
}
