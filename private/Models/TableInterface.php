<?php


interface TableInterface
{
    public function create(array $data): TableInterface;

    public function find($value): ?TableInterface;

    public function update(array $data): TableInterface;

    public function where(string $column, string $value): array;
}