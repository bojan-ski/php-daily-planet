<?php

declare(strict_types=1);

namespace App\Controllers;

use Exception;
use Framework\Database;
use Framework\Session;

class ReaderUserController extends Database
{
    protected Database $db;
    public string $backPath;

    public function __construct()
    {
        $config = require basePath('config/db.php');
        $this->db = new Database($config);
        $this->backPath = getPagePaths()[0];
    }

    public function displayReaderProfilePage(): void
    {
        // get user from session
        (array) $user = Session::get('user');

        if (isset($user)) {
            // get all bookmarked articles (ids) from bookmarked table 
            (array) $userId = [
                'id' => Session::get('user')['id']
            ];

            try {
                (array) $bookmarkedArticlesIds = $this->db->dbQuery("SELECT * FROM bookmarked WHERE user_id = :id", $userId)->fetchAll();
            } catch (Exception $e) {
                ErrorController::randomError('There was an error while displaying user bookmarked articles');
                exit;
            }

            // if reader user has bookmarked articles
            if ($bookmarkedArticlesIds) {
                // Extract all article_id
                (array) $articleIds = array_column($bookmarkedArticlesIds, "article_id");

                // get all bookmarked articles from articles table
                $placeholders = [];
                $params = [];
                foreach ($articleIds as $index => $id) {
                    $key = "id$index";
                    $placeholders[] = ":$key";
                    $params[$key] = $id;
                }

                $query = "SELECT * FROM articles WHERE id IN (" . implode(', ', $placeholders) . ")";

                try {
                    (array) $bookmarkedArticles = $this->db->dbQuery($query, $params)->fetchAll();
                } catch (Exception $e) {
                    ErrorController::randomError('There was an error while displaying user bookmarked articles');
                    exit;
                }
            }

            // load view
            loadView('readerUser/profile', [
                'user' => $user,
                'bookmarkedArticles' => $bookmarkedArticles ?? ''
            ]);
        } else {
            ErrorController::accessDenied();
            exit;
        }
    }

    public function bookmarkFeature(array $params): void
    {
        if (Session::exist('user') && Session::get('user')['role'] == 'reader') {
            (string) $userId = Session::get('user')['id'] ?? '';
            (string) $articleId = $params['id'] ?? '';

            // check if article is bookmarked
            (array) $bookmarkParams = [
                'user_id' => $userId,
                'article_id' => $articleId
            ];

            try {
                (array) $isBookmarked = $this->db->dbQuery("SELECT * FROM bookmarked WHERE user_id = :user_id AND article_id = :article_id", $bookmarkParams)->fetch();
            } catch (Exception $e) {
                ErrorController::randomError();
                exit;
            }

            // if bookmarked
            if ($isBookmarked) {
                try {
                    $this->db->dbQuery("DELETE FROM bookmarked WHERE user_id = :user_id AND article_id = :article_id", $bookmarkParams);

                    // store pop up msg in session
                    Session::set('pop_up', [
                        'message' => 'Bookmark removed'
                    ]);

                    //redirect user 
                    redirectUser("/$this->backPath/" . $params['id']);
                } catch (Exception $e) {
                    ErrorController::randomError('There was an error while removing the bookmark');
                    exit;
                }
            } else {
                // if not bookmarked
                (array) $newBookmark = [
                    'user_id' => $userId,
                    'article_id' => $articleId,
                    'created_at' => date("Y-m-d h:i:s")
                ];

                try {
                    $this->db->dbQuery("INSERT INTO bookmarked (`user_id`, `article_id`, `created_at`) VALUES (:user_id, :article_id, :created_at)", $newBookmark);

                    // store pop up msg in session
                    Session::set('pop_up', [
                        'message' => 'Article bookmarked'
                    ]);

                    //redirect user 
                    redirectUser("/$this->backPath/" . $params['id']);
                } catch (Exception $e) {
                    ErrorController::randomError('There was an error while bookmarking the article');
                    exit;
                }
            }
        } else {
            ErrorController::randomError();
            exit;
        }
    }

    public function deleteAccount(): void
    {
        // get reader user id
        (array) $userId = [
            'id' => Session::get('user')['id']
        ];

        if (isset($userId['id'])) {
            try {
                // delete account from db
                $this->db->dbQuery("DELETE FROM users WHERE id = :id", $userId);

                // delete user data from session
                Session::clearAll();

                //redirect user 
                redirectUser("/");
            } catch (Exception $e) {
                ErrorController::randomError('User does not exist');
                exit;
            }
        } else {
            ErrorController::randomError('You not able to perform the following action!');
            exit;
        }
    }
}
