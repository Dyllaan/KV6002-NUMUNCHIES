<?php

/**
 * class SelectQuery
 * SelectQuery is used to build a select query in an object oriented way
 * @generated Github CoPilot was used during the creation of this code
 */

namespace Core\Database\Queries;

class SelectQuery extends \Core\Database\Query implements \Core\Database\QueryInterface
{
    private $cols;
    private $where;
    private $joins;
    private $limit;
    private $offset;
    private $orderBy;

    public function cols($cols)
    {
        $this->cols = "SELECT $cols";
        return $this;
    }

    public function from($table)
    {
        $this->table = "FROM $table";
        return $this;
    }

    public function where($conditions)
    {
        $this->where = $this->conditionFormatter($conditions);
        return $this;
    }

    public function join($table, $on)
    {
        $this->joins[] = "LEFT JOIN $table ON $on";
        return $this;
    }

    public function limit($limit)
    {
        $this->limit = "LIMIT $limit";
        return $this;
    }

    public function offset($offset)
    {
        $this->offset = "OFFSET $offset";
        return $this;
    }

    public function orderBy($orderBy)
    {
        $this->orderBy = "ORDER BY $orderBy";
        return $this;
    }

    public function exists($subQuery, $alias = "found") {
        $this->cols = "SELECT EXISTS ($subQuery) AS $alias";
        return $this;
    }

    public function assemble() {
        $parts = [
            $this->cols,
            $this->table,
            !empty($this->joins) ? implode(" ", $this->joins) : null,
            $this->where,
            $this->orderBy,
            $this->limit,
            $this->offset,
        ];

        $parts = array_filter($parts);

        $query = implode(" ", $parts);
        return $query;
    }


    /**
     * Assembles the query and executes it
     * does a check on joins or it throws an error that joins is not an array
     */
    public function execute()
    {
        return $this->db->executeQuery($this->assemble());
    }
}
