<?php

use App\Controllers\HomeController;

require __DIR__ . '/vendor/autoload.php';

// import helper
require './utils/helpers.php';

$nesto = new HomeController();
$nesto->latestArticles();
