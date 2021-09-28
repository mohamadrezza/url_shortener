<?php

use Bootstrap\App;
use Database\Connection;
use Database\QueryBuilder;

//App::bind('config', require '../config.php');


App::bind('database', new QueryBuilder(
     Connection::make()
));

