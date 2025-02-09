<?php

declare(strict_types=1);

// ----- GENERAL - ALL USERS -----
//get
$router->get('/', 'HomeController', 'latestArticles');
$router->get('/articles', 'ArticlesController', 'articlesList');