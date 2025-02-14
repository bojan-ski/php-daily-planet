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

// ----- AUTHOR USER -----
$router->get('/my_active_articles', 'ManageArticlesController', 'displayMyActiveArticlesPage');
$router->get('/my_pending_articles', 'ManageArticlesController', 'displayMyPendingArticlesPage');
$router->get('/submit_article', 'ManageArticlesController', 'submitNewArticlePage');
$router->post('/submit_article/submitArticle', 'ManageArticlesController', 'submitArticle');

// ----- AUTHOR USER & ADMIN USER -----
$router->delete('/articles/{id}', 'ManageArticlesController', 'deleteSelectedArticle');