<?php

declare(strict_types=1);

$pageUri = getPagePaths()[0];

// ----- GENERAL - ALL USERS -----
// article/articles
$router->get('/', 'HomeController', 'latestArticles', ['guest', 'reader', 'author', 'admin']);
$router->get('/articles', 'ArticlesController', 'displayArticlesPage', ['guest', 'reader', 'author', 'admin']);
$router->post('/articles/search', 'ArticlesController', 'searchArticle', ['guest', 'reader', 'author', 'admin']);
$router->get("/{$pageUri}/{id}", 'ArticlesController', 'displaySelectedArticlePage', ['guest', 'reader', 'author', 'admin']);
// auth - sign up
$router->get('/sign_up', 'AuthController', 'displaySignUpPage', ['guest']);
$router->post('/sign_up/register', 'AuthController', 'register', ['guest']);
// auth - sign in
$router->get('/sign_in', 'AuthController', 'displaySignInPage', ['guest']);
$router->post('/sign_in/login', 'AuthController', 'login', ['guest']);
// auth - log out
$router->post('/logout', 'AuthController', 'logout', ['reader', 'author', 'admin']);

// ----- READER USER -----
$router->get('/profile', 'ReaderUserController', 'displayReaderProfilePage', ['reader']);
$router->delete('/profile/deleteAccount', 'ReaderUserController', 'deleteAccount', ['reader']);
$router->post("/{$pageUri}/{id}/bookmarkFeature", 'ReaderUserController', 'bookmarkFeature', ['reader']);
$router->delete("/{$pageUri}/{id}/bookmarkFeature", 'ReaderUserController', 'bookmarkFeature', ['reader']);

// ----- AUTHOR USER -----
$router->get('/my_active_articles', 'ManageArticlesController', 'displayAuthorActiveArticlesPage', ['author']);
$router->get('/my_pending_articles', 'ManageArticlesController', 'displayAuthorPendingArticlesPage', ['author']);
$router->get('/submit_article', 'ManageArticlesController', 'displaySubmitNewArticlePage', ['author']);
$router->post('/submit_article/submitArticle', 'ManageArticlesController', 'submitArticle', ['author']);

// ----- AUTHOR USER & ADMIN USER -----
$router->get("/{$pageUri}/edit/{id}", 'ManageArticlesController', 'displayEditSelectedArticlePage', ['author', 'admin']);
$router->put("/{$pageUri}/edit/{id}/editSelectedArticle", 'ManageArticlesController', 'editSelectedArticle', ['author', 'admin']);
$router->delete("/{$pageUri}/{id}/deleteSelectedArticle", 'ManageArticlesController', 'deleteSelectedArticle', ['author', 'admin']);

// ----- ADMIN USER -----
$router->get('/pending_articles', 'ManageArticlesController', 'displayAllPendingArticlesPage', ['admin']);
$router->put('/pending_articles/{id}/approveSelectedArticle', 'ManageArticlesController', 'approveSelectedArticle', ['admin']);
$router->get('/authors', 'ManageAppUsersController', 'displayAuthorsPage', ['admin']);
$router->delete('/authors/removeAuthor', 'ManageAppUsersController', 'removeAuthor', ['admin']);
$router->get('/add_author', 'ManageAppUsersController', 'displayAddAuthorPage', ['admin']);
$router->post('/add_author/addAuthor', 'ManageAppUsersController', 'addAuthor', ['admin']);
$router->get('/readers', 'ManageAppUsersController', 'displayReadersPage', ['admin']);
