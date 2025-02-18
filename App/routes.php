<?php

declare(strict_types=1);

$pageUri = getPagePaths()[0];

// ----- GENERAL - ALL USERS -----
// article/articles
$router->get('/', 'HomeController', 'latestArticles');
$router->get('/articles', 'ArticlesController', 'displayArticlesPage');
$router->get("/{$pageUri}/{id}", 'ArticlesController', 'displaySelectedArticlePage');
// auth - sign up
$router->get('/sign_up', 'AuthController', 'displaySignUpPage');
$router->post('/sign_up/register', 'AuthController', 'register');
// auth - sign in
$router->get('/sign_in', 'AuthController', 'displaySignInPage');
$router->post('/sign_in/login', 'AuthController', 'login');
// auth - log out
$router->post('/logout', 'AuthController', 'logout');

// ----- READER USER -----
$router->get('/profile', 'ReaderUserController', 'displayReaderProfilePage');
$router->delete('/profile', 'ReaderUserController', 'deleteAccount');
$router->post("/{$pageUri}/{id}", 'ReaderUserController', 'bookmarkFeature');
$router->delete("/{$pageUri}/{id}", 'ReaderUserController', 'bookmarkFeature');

// ----- AUTHOR USER -----
$router->get('/my_active_articles', 'ManageArticlesController', 'displayAuthorActiveArticlesPage');
$router->get('/my_pending_articles', 'ManageArticlesController', 'displayAuthorPendingArticlesPage');
$router->get('/submit_article', 'ManageArticlesController', 'displaySubmitNewArticlePage');
$router->post('/submit_article/submitArticle', 'ManageArticlesController', 'submitArticle');

// ----- AUTHOR USER & ADMIN USER -----
$router->get("/{$pageUri}/edit/{id}", 'ManageArticlesController', 'displayEditSelectedArticlePage');
$router->put("/{$pageUri}/edit/{id}", 'ManageArticlesController', 'editSelectedArticle');
$router->delete("/{$pageUri}/{id}", 'ManageArticlesController', 'deleteSelectedArticle');

// ----- ADMIN USER -----
$router->get('/pending_articles', 'ManageArticlesController', 'displayAllPendingArticlesPage');
$router->put('/pending_articles/{id}', 'ManageArticlesController', 'approveSelectedArticle');
$router->get('/authors', 'ManageAppUsersController', 'displayAuthorsPage');
$router->delete('/authors', 'ManageAppUsersController', 'removeAuthor');
$router->get('/readers', 'ManageAppUsersController', 'displayReadersPage');
