<?php

namespace Database;

use Config\Database;

class Connection
{

    public static function make()
    {
        try {
            return new \PDO(Database::DB_CONNECTION . ":host=" . Database::DB_HOST . ";dbname=" . Database::DB_NAME,
                Database::DB_USERNAME,
                Database::DB_PASSWORD,Database::OPTIONS);

        } catch (\PDOException $e) {
            return "Connection failed: " . $e->getMessage();
        }
    }
}


