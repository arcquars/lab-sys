<?php

namespace Tests\Support;

use Closure;
use Illuminate\Database\Connection;
use Illuminate\Database\Query\Builder;

/** A query-builder double: no PDO, SQL execution or database writes. */
class IndustrialSampleMemoryConnection extends Connection
{
    public $tables = [];
    public $failOn;
    public $commits = 0;
    public $rollbacks = 0;
    public $lockedRead = false;

    public function __construct()
    {
        parent::__construct(function () {
            throw new \LogicException('These tests must never open a database connection.');
        });
    }

    public function query()
    {
        return new IndustrialSampleMemoryQuery($this, $this->getQueryGrammar(), $this->getPostProcessor());
    }

    public function transaction(Closure $callback, $attempts = 1)
    {
        $snapshot = $this->tables;
        $this->transactions++;
        try {
            $result = $callback($this);
            $this->commits++;
            return $result;
        } catch (\Throwable $e) {
            $this->tables = $snapshot;
            $this->rollbacks++;
            throw $e;
        } finally {
            $this->transactions--;
        }
    }

    public function checkWrite($table, $operation)
    {
        if ($this->transactions === 0) {
            throw new \LogicException('Controller write outside its transaction: ' . $table);
        }
        if ($this->failOn === [$table, $operation]) {
            throw new \RuntimeException('Simulated persistence failure');
        }
    }
}

class IndustrialSampleMemoryQuery extends Builder
{
    private function column($column)
    {
        $parts = explode('.', $column);
        return end($parts);
    }

    private function matches(array $row)
    {
        foreach ($this->wheres ?? [] as $where) {
            $value = $row[$this->column($where['column'])] ?? null;
            switch ($where['type']) {
                case 'Basic':
                    if ($where['operator'] !== '=' || $value != $where['value']) return false;
                    break;
                case 'In':
                case 'InRaw':
                    if (!in_array($value, $where['values'])) return false;
                    break;
                case 'NotNull':
                    if ($value === null) return false;
                    break;
                case 'Null':
                    if ($value !== null) return false;
                    break;
                default:
                    throw new \LogicException('Unsupported memory query: ' . $where['type']);
            }
        }
        return true;
    }

    public function get($columns = ['*'])
    {
        if ($this->lock) $this->connection->lockedRead = true;
        $rows = array_filter($this->connection->tables[$this->from] ?? [], function ($row) {
            return $this->matches($row);
        });
        if ($this->limit !== null) $rows = array_slice($rows, 0, $this->limit);
        return collect(array_values($rows))->map(function ($row) { return (object) $row; });
    }

    public function pluck($column, $key = null)
    {
        return $this->get()->pluck($this->column($column), $key);
    }

    public function insertGetId(array $values, $sequence = null)
    {
        $rows = $this->connection->tables[$this->from] ?? [];
        $values['id'] = empty($rows) ? 1 : max(array_column($rows, 'id')) + 1;
        $this->insert($values);
        return $values['id'];
    }

    public function insert(array $values)
    {
        $this->connection->checkWrite($this->from, 'insert');
        $this->connection->tables[$this->from][] = $values;
        return true;
    }

    public function update(array $values)
    {
        $this->connection->checkWrite($this->from, 'update');
        $count = 0;
        foreach ($this->connection->tables[$this->from] ?? [] as $i => $row) {
            if (!$this->matches($row)) continue;
            $this->connection->tables[$this->from][$i] = array_merge($row, $values);
            $count++;
        }
        return $count;
    }

    public function delete($id = null)
    {
        $this->connection->checkWrite($this->from, 'delete');
        if ($id !== null) $this->where('id', $id);
        $rows = $this->connection->tables[$this->from] ?? [];
        $retained = array_filter($rows, function ($row) { return !$this->matches($row); });
        $this->connection->tables[$this->from] = array_values($retained);
        return count($rows) - count($retained);
    }
}
