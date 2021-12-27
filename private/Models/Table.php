<?php

use \http\Exception\BadMethodCallException;

abstract class Table Implements TableInterface
{
    private array $records = [];

    abstract protected function getTablePath(): string;

    abstract protected function getTableFields(): array;

    abstract protected function getIdField(): string;

    protected function parseRecordsFromFile(): array
    {
        $tablePath = $this->getTablePath();
        $fh = fopen($tablePath,'a+');
        rewind($fh);

        if (filesize($tablePath) === 0) {
            return [];
        }

        $records = [];
        while ($line = fgetcsv($fh)) {
            $records[] = array_combine($this->getTableFields(), $line);
        }

        return $records;
    }

    protected function getAllRecords(): array
    {
        if ($this->records) {
            return $this->records;
        }

        return $this->records = $this->parseRecordsFromFile();
    }

    /**
     * TODO: ADD DESCRIPTION
     * @param string $column
     * @param string $value
     * @return array
     */
    public function where(string $column, string $value): array
    {
        $records = $this->getAllRecords();

        return  array_filter($records, function ($record) use ($column, $value) {
            if ($record[$column] == $value) {
                return $record;
            }
        });
    }

    public function create(array $data): TableInterface
    {
        $fh = fopen($this->getTablePath(),'a+');

        fputcsv($fh, $data);

        $this->{$this->getIdField()} = $data[$this->getIdField()];
        $this->setProperties($data);

        return $this;
    }

    /**
     * Returns the first record where idField matches the value
     *
     * @param string $value
     * @return $this|null
     */
    public function find($value): ?TableInterface
    {
        $this->records = $this->getAllRecords();

        $position = array_search($value , array_column($this->records, $this->getIdField()));
        if ($position === false) {
            return null;
        }

        $this->{$this->getIdField()} = $this->records[$position][$this->getIdField()];
        $this->setProperties($this->records[$position]);

        return $this;
    }

    public function update(array $data): TableInterface
    {
        if (empty($this->getIdField())) {
            throw new BadMethodCallException('update can be called only on object fetched from DB', 500);
        }

        $this->setProperties($data);

        return $this->save();
    }

    protected function save(): TableInterface
    {
        $records = $this->getAllRecords();

        $position = array_search($this->{$this->getIdField()} , array_column($records, $this->getIdField()));

        foreach ($this->getTableFields() as $field) {
            $records[$position][$field] = $this->{$field};
        }

        $this->saveAllToDB($records);

        return $this;
    }

    private function saveAllToDB(array $records): void
    {
        $fh = fopen($this->getTablePath(),'a+');
        ftruncate($fh,0);

        foreach ($records as $record) {
            fputcsv($fh, $record);
        }

        fclose($fh);
    }

    private function setProperties(array $data): void
    {
        foreach ($data as $key => $value) {
            if ($key == $this->getIdField()) {
                continue;
            }

            if (! in_array($key, $this->getTableFields())) {
                continue;
            }

            $this->{$key} = $value;
        }
    }
}