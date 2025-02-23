<?php

declare(strict_types=1);

// import autoload
require __DIR__ . '/vendor/autoload.php';

// import .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// import & instantiate session
use Framework\Session;

Session::start();

// import & instantiate router
use Framework\Router;

$router = new Router();

// import helpers
require './utils/helpers.php';

// import routes
$routes = require basePath('App/routes.php');

// app - user routes
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

$router->route($uri, $method);
