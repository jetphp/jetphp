<?php

use JetPHP\Model\DB;

class Crud
{
    // protected $con;
    private $sql;
    private $qr;

    public $joinArr;
    public $join;

    private $where, $groupBy, $orderBy, $where_vars;

    private $preCols = '';
    private $cond = '';
    public function getSQL()
    {
        return $this->sql;
    }
    public function getColumns()
    {
        $qr = $this->qr;
        $count = $this->qr->generico()->columnCount();
        $cols = [];
        for ($i = 0; $i < $count; $i++) {
            $cols[] = $qr->generico()->getColumnMeta($i)['name'];
        }
        return $cols;
    }
    public function insert($table, $values)
    {
        $cols = [];
        $vals = [];
        $arr = [];
        foreach ($values as $k => $v) :
            $cols[] = $k;
            $vals[] = '?';
            $arr[] = $v;
        endforeach;
        $cols = implode(',', $cols);
        $vals = implode(',', $vals);
        $this->sql = "INSERT INTO {$table} ({$cols}) VALUES ({$vals})";
        $this->qr = DB::getInstance()->execute($this->sql, $arr);
        // print_r($this->qr->generico()->errorInfo());
        return $this->qr;
    }
    public function update($table, $values, $where)
    {
        $where = (is_string($where) ? $where : is_array($where) ? array_map(function ($i, $v) {
            return [$i => $v];
        }, array_keys($where), $where) : '');
        // print_r($where);
        $this->sql = "UPDATE {$table} SET " . implode(',=?', array_keys($values)) . " WHERE {$where}";
        $this->qr = DB::getInstance()->execute($this->sql, $values);
        return $this->qr;
    }

    public function when($case, $then) {
        $this->when = "CASE ";
    }

    // Select
    public function addCondition($column, $value, $operator = '=')
    {
        $this->cond = "{$column}{$operator}{$value}";
    }
    public function join(string $table, string $type = 'INNER')
    {
        $join = "{$type} JOIN {$table} ON ";
        $joinFunc = new class ($this, $table, $join)
        {
            public $join;
            public $joinArr;
            public function __construct($parent, $table, $join)
            {
                $this->parent = $parent;
                $this->table = $table;
                $this->joinArr[] = $join;
            }
            public function on($column, $value, $operator = '=')
            {
                $this->joinArr[] = "{$this->table}.{$column} {$operator} {$value}";
                return $this;
            }
            public function and($column, $value, $operator = '=')
            {
                $this->joinArr[] = 'and';
                $arg = func_get_args();
                call_user_func_array([&$this, 'on'], $arg);
                return $this;
            }
            public function or()
            {
                $this->joinArr[] = 'or';
                $arg = func_get_args();
                call_user_func_array([&$this, 'on'], $arg);
                return $this;
            }
            public function add()
            {
                $this->parent->join .= implode(' ', $this->joinArr) . "\n";
                return $this->parent;
            }
        };
        return $joinFunc;
    }
    public function getJoin()
    {
        return $this->join;
    }
    public function select($cols, $table)
    {
        $this->sql = "SELECT {$this->preCols}{$cols} FROM {$table} {$this->getJoin()} {$this->where} {$this->groupBy} {$this->orderBy}";
        $this->qr = DB::getInstance()->execute($this->sql, $this->where_vars);
        return $this->qr;
    }
    public function delete($table) {
        if ($this->where != null) {
            $this->sql = "DELETE FROM {$table} {$this->where}";
            $this->qr = DB::getInstance()->execute($this->sql, $this->where_vars);
            return $this->qr;
        } else {
            return false;
        }
    }


    public function order($col, $direction = 'ASC')
    {
        $this->orderBy = 'ORDER BY ' . implode(' ', [$col, $direction]);
        return $this;
    }
    public function where($where, $val = null)
    {
        $this->where = 'WHERE ' . $where;
        if ($val != null) {
            $this->where_vars = [$val];
        }
        return $this;
    }
    public function groupBy($col)
    {
        $this->groupBy = "GROUP BY {$col}";
        return $this;
    }

    public static function getInstance()
    {
        return new Crud;
    }
}
