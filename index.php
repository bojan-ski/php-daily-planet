<?php

declare(strict_types=1);

// import autoload
require __DIR__ . '/vendor/autoload.php';

// import & insatiate router
use Framework\Router;

$router = new Router();

// import helpers
require './utils/helpers.php';

// import routes
$routes = require basePath('App/routes.php');

// app - user routes
$uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

$router->route($uri, $method);
