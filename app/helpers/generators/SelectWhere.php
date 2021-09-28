<?php

namespace Helpers\Generators;

/**
 * Class SelectWhere generate select sql command based on columns and conditions
 * @package Helpers\Generators
 */
class SelectWhere
{
    private $conditions, $columns, $table;
    public $command;

    public function __construct($table)
    {
        $this->table = $table;
    }

    public function setConditions($conditions)
    {
        if (count($conditions) == 0) {
            $this->conditions = '';
            return;
        }

        $mainCondition = $conditions[0][0];
        $operator = $conditions[0][1];
        $value = $conditions[0][2];

        $this->conditions = "where $mainCondition $operator '$value'";

        if (count($conditions) > 1) {
            array_shift($conditions);
            foreach ($conditions as $condition) {
                $this->conditions .= " and $condition[0] $condition[1] '$condition[2]' ";
            }
        }

    }

    public function setColumns($columns)
    {
        $this->columns = count($columns) > 0 ? implode(',', $columns) : '*';

    }

    public function generate()
    {
        $this->command = "select $this->columns from $this->table $this->conditions";
    }

}