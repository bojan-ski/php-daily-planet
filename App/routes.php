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
$router->get('/my_active_articles', 'ManageArticlesController', 'displayAuthorActiveArticlesPage');
$router->get('/my_pending_articles', 'ManageArticlesController', 'displayAuthorPendingArticlesPage');
$router->get('/submit_article', 'ManageArticlesController', 'displaySubmitNewArticlePage');
$router->post('/submit_article/submitArticle', 'ManageArticlesController', 'submitArticle');

// ----- AUTHOR USER & ADMIN USER -----
$router->get('/articles/edit/{id}', 'ManageArticlesController', 'displayEditSelectedArticlePage');
$router->put('/articles/edit', 'ManageArticlesController', 'editSelectedArticle');
$router->delete('/articles/{id}', 'ManageArticlesController', 'deleteSelectedArticle');

// ----- ADMIN USER -----
$router->get('/pending_articles', 'ManageArticlesController', 'displayAllPendingArticlesPage');
$router->put('/articles/{id}', 'ManageArticlesController', 'approveSelectedArticle');