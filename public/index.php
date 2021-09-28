<?php
/*
 * The starting point for the framework.
 */
require '../vendor/autoload.php';
require '../bootstrap/bootstrap.php';

use Bootstrap\Facades\Router;
use App\Request;

session_start();


Router::load('../router/api.php')->direct(Request::uri(), Request::method());


