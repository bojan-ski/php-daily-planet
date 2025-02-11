<?php

declare(strict_types=1);

// ----- GENERAL - ALL USERS -----
// article/articles
$router->get('/', 'HomeController', 'latestArticles');
$router->get('/articles', 'ArticlesController', 'displayArticlesPage');
$router->get('/articles/{id}', 'ArticlesController', 'displaySelectedArticlePage');
// auth - sign up
$router->get('/sign_up', 'UserController', 'displaySignUpPage');
$router->post('/sign_up/register', 'UserController', 'register');
// auth - sign in
$router->get('/sign_in', 'UserController', 'displaySignInPage');
$router->post('/sign_in/login', 'UserController', 'login');
// auth - log out
$router->post('/logout', 'UserController', 'logout');