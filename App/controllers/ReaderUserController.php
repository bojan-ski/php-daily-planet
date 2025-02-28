<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\ArticlesModels;
use Framework\Session;
use Exception;

class ReaderUserController extends ArticlesModels
{
    private array $user;
    public string $backPath;

    public function __construct()
    {
        parent::__construct();

        $this->user = (Session::exist('user') && Session::get('user')['role'] == 'reader') ? Session::get('user') : null;

        $this->backPath = getPagePaths()[0];
    }

    public function displayReaderProfilePage(): void
    {
        if (isset($this->user)) {
            // get all bookmarked articles (ids) from bookmarked table 
            $bookmarkedArticlesIds = $this->fetchBookmarkedArticles($this->user);

            // if reader user has bookmarked articles
            if ($bookmarkedArticlesIds) {
                // Extract all article_id
                $articleIds = array_column($bookmarkedArticlesIds, "article_id");

                // get all bookmarked articles from articles table
                $placeholders = [];
                $params = [];
                foreach ($articleIds as $index => $id) {
                    $key = "id$index";
                    $placeholders[] = ":$key";
                    $params[$key] = $id;
                }

                $query = "SELECT * FROM articles WHERE id IN (" . implode(', ', $placeholders) . ")";

                // $bookmarkedArticles = $this->fetchArticles($query, $params);
            }

            // load view
            loadView('readerUser/profile', [
                'user' => $this->user,
                'bookmarkedArticles' => $bookmarkedArticles ?? ''
            ]);
        } else {
            ErrorController::accessDenied();
            exit;
        }
    }

    public function bookmarkFeature(array $params): void
    {
        if (isset($this->user)) {
            $userId = (string) Session::get('user')['id'] ?? '';
            $articleId = (string) $params['id'] ?? '';

            // check if article is bookmarked
            (array) $bookmarkParams = [
                'user_id' => $userId,
                'article_id' => $articleId
            ];

                $isBookmarked = $this->isArticleBookmarked($bookmarkParams);

            // if bookmarked
            if ($isBookmarked) {
                $this->addBookmark($bookmarkParams, $this->backPath, $params['id']);
            } else {
                // if not bookmarked
                (array) $newBookmark = [
                    'user_id' => $userId,
                    'article_id' => $articleId,
                    'created_at' => date("Y-m-d h:i:s")
                ];

                $this->removeBookmark($newBookmark, $this->backPath, $params['id'] );
            }
        } else {
            ErrorController::randomError('You not able to perform the following action!');
            exit;
        }
    }

    public function deleteAccount(): void
    {
        if (isset($this->user)) {
            // get all bookmarked articles (ids) from bookmarked table 
            $bookmarkedArticlesIds = $this->fetchBookmarkedArticles($this->user);

            if (empty($bookmarkedArticlesIds)) {
                // get reader user id
                (array) $userId = [
                    'id' => $this->user['id'] ?? null
                ];

                try {
                    // delete account from db
                    $this->dbQuery("DELETE FROM users WHERE id = :id", $userId);

                    // delete user data from session
                    Session::clearAll();

                    //redirect user 
                    redirectUser("/");
                } catch (Exception $e) {
                    ErrorController::randomError('User does not exist');
                    exit;
                }
            } else {
                // store pop up msg in session
                Session::set('pop_up', [
                    'message' => 'Please remove all bookmarked articles'
                ]);

                //redirect user 
                redirectUser("/profile");
            }
        } else {
            ErrorController::randomError('You not able to perform the following action!');
            exit;
        }
    }
}
