<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\ArticlesModels;
use App\Models\UsersModels;
use Framework\Session;

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
            $bookmarkedArticlesIds = $this->fetchBookmarkedArticlesId($this->user);

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

                $bookmarkedArticles = $this->fetchBookmarkedArticles($placeholders, $params);
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
            $userId = $this->user['id'] ?? '';
            $articleId = $params['id'] ?? '';

            // check if article is bookmarked
            $bookmarkParams = [
                'user_id' => $userId,
                'article_id' => $articleId
            ];

            $isBookmarked = $this->isArticleBookmarked($bookmarkParams);

            // if bookmarked
            if ($isBookmarked) {
                $this->addBookmark($bookmarkParams, $this->backPath, $articleId);
            } else {
                // if not bookmarked
                $newBookmark = [
                    'user_id' => $userId,
                    'article_id' => $articleId,
                    'created_at' => date("Y-m-d h:i:s")
                ];

                $this->removeBookmark($newBookmark, $this->backPath, $articleId);
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
            $bookmarkedArticlesIds = $this->fetchBookmarkedArticlesId($this->user);

            if (empty($bookmarkedArticlesIds)) {
                // get reader user id
                $userId = [
                    'id' => $this->user['id'] ?? null
                ];

                $delete = new UsersModels;
                $delete->deleteReaderUserAccount($userId);
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
