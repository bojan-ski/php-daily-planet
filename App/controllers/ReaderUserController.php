<?php

declare(strict_types=1);

namespace App\Controllers;

use Exception;
use Framework\Database;
use Framework\Session;

class ReaderUserController extends Database
{
    protected Database $db;

    public function __construct()
    {
        $config = require basePath('config/db.php');
        $this->db = new Database($config);
    }

    public function displayReaderProfilePage(): void
    {
        // get user from session
        (array) $user = Session::get('user');

        if (isset($user)) {
            $bookmarkedArticles = [];

            // load view
            loadView('readerUser/profile', [
                'user' => $user,
                'bookmarkedArticles' => $bookmarkedArticles
            ]);
        } else {
            ErrorController::randomError('You are not logged in!');
            return;
        }
    }

    public function bookmarkSelectedArticle($params): void
    {
        (array) $bookmarkParams = [
            'user_id' => Session::get('user')['id'],
            'article_id' => $params['id']
        ];

        // check if article is bookmarked
        try {
            (array) $isBookmarked = $this->db->dbQuery("SELECT * FROM bookmarked WHERE user_id = :user_id AND article_id = :article_id", $bookmarkParams)->fetch();
        } catch (Exception $e) {
            ErrorController::randomError('');
            return;
        }
        
        // if bookmarked
        if($isBookmarked){   
            // MESSAGE - ARTICLE IS BOOKMARKED DELETED

            //redirect user 
            redirectUser('/articles');
            // redirectUser('/articles/' . $params['id']);
        }

        // if not bookmarked
        (array) $newBookmark = [
            'user_id' => Session::get('user')['id'],
            'article_id' => $params['id'],
            'created_at' => date("Y-m-d h:i:s")
        ];

        try {
            $this->db->dbQuery("INSERT INTO bookmarked (`user_id`, `article_id`, `created_at`) VALUES (:user_id, :article_id, :created_at)", $newBookmark);

            // MESSAGE - ARTICLE BOOKMARKED

            //redirect user 
            redirectUser('/articles/' . $params['id']);
        } catch (Exception $e) {
            ErrorController::randomError('There was an error while bookmarking the article');
            return;
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

                // delete user data from session from db
                Session::clearAll();

                // MESSAGE - ACCOUNT DELETED

                //redirect user 
                redirectUser("/");
            } catch (Exception $e) {
                ErrorController::randomError('User does not exist');
                return;
            }
        } else {
            ErrorController::randomError('You not able to perform the following action!');
            return;
        }
    }
}
