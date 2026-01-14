<?php

namespace App\Contracts\Table;

interface TableFilter
{
    public function getName(): string;

    public function getLabel(): string;

    public function getType(): string;

    public function getComponent(): ?string;

    public function getOptions(): array;

    public function apply($query, $value): void;

    public function validate($value): bool;
}
