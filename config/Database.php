<?php
namespace Config;

use PDO;
class Database{
    const DB_HOST = '127.0.0.1';

    const DB_CONNECTION='mysql';

    const DB_NAME = 'shortener';


    const DB_USERNAME = 'root';


    const DB_PASSWORD = '';


    const OPTIONS= [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_CASE => PDO::CASE_NATURAL,
        PDO::ATTR_EMULATE_PREPARES=> false,
    ];
}