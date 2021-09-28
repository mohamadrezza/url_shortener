<?php

namespace Database;

use Helpers\Generators\SelectWhere;
use PDO;

class QueryBuilder
{

    protected $pdo;

    protected $command;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getPdo(): PDO
    {
        return $this->pdo;
    }



    public function store(string $table, $parameters)
    {

        $keys = getColumns($parameters);
        $values = getValues($parameters);


        $this->command = sprintf(
            'INSERT INTO %s (%s) VALUES (%s)',
            $table,
            $keys,
            $values
        );
        try {
            $statement = $this->pdo->prepare($this->command);
            $statement->execute($parameters);
            return $this->pdo->lastInsertId();
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function deleteById(string $table, $id,$userId)
    {
        $this->command = "DELETE FROM $table WHERE id=$id AND user_id=$userId";

        try {
            $statement = $this->pdo->prepare($this->command);
            $statement->execute();
        } catch (\PDOException $e) {
            return $e->getMessage();
        }
    }

    public function find($table, $columns = [], $conditions = [])
    {
        $commandHelper = new SelectWhere($table);
        $commandHelper->setColumns($columns);
        $commandHelper->setConditions($conditions);
        $commandHelper->generate();

        $this->command = $commandHelper->command;

        try {
            $statement = $this->pdo->prepare($this->command);
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_CLASS);

        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function updateById($table, $id, $data)
    {
        $updateFields = generateUpdateFieldsCommand($data);

        $this->command = "update $table set $updateFields where id =$id";
        try {
            $statement = $this->pdo->prepare($this->command);
            $statement->execute();

            return $statement->rowCount();
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function recordExists($table, $column, $value)
    {
        $this->command = "select count(*) as count from $table where $column='$value'";
        try {
            $statement = $this->pdo->prepare($this->command);
            $statement->execute();
            return $statement->fetchColumn() > 0;

        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }


}
