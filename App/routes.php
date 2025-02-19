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
$router->delete('/profile/deleteAccount', 'ReaderUserController', 'deleteAccount');
$router->post("/{$pageUri}/{id}/bookmarkFeature", 'ReaderUserController', 'bookmarkFeature');
$router->delete("/{$pageUri}/{id}/bookmarkFeature", 'ReaderUserController', 'bookmarkFeature');

// ----- AUTHOR USER -----
$router->get('/my_active_articles', 'ManageArticlesController', 'displayAuthorActiveArticlesPage');
$router->get('/my_pending_articles', 'ManageArticlesController', 'displayAuthorPendingArticlesPage');
$router->get('/submit_article', 'ManageArticlesController', 'displaySubmitNewArticlePage');
$router->post('/submit_article/submitArticle', 'ManageArticlesController', 'submitArticle');

// ----- AUTHOR USER & ADMIN USER -----
$router->get("/{$pageUri}/edit/{id}", 'ManageArticlesController', 'displayEditSelectedArticlePage');
$router->put("/{$pageUri}/edit/{id}/editSelectedArticle", 'ManageArticlesController', 'editSelectedArticle');
$router->delete("/{$pageUri}/{id}/deleteSelectedArticle", 'ManageArticlesController', 'deleteSelectedArticle');

// ----- ADMIN USER -----
$router->get('/pending_articles', 'ManageArticlesController', 'displayAllPendingArticlesPage');
$router->put('/pending_articles/{id}/approveSelectedArticle', 'ManageArticlesController', 'approveSelectedArticle');
$router->get('/authors', 'ManageAppUsersController', 'displayAuthorsPage');
$router->delete('/authors/removeAuthor', 'ManageAppUsersController', 'removeAuthor');
$router->get('/add_author', 'ManageAppUsersController', 'displayAddAuthorPage');
$router->post('/add_author/addAuthor', 'ManageAppUsersController', 'addAuthor');
$router->get('/readers', 'ManageAppUsersController', 'displayReadersPage');
