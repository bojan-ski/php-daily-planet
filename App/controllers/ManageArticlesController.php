<?php

declare(strict_types=1);

namespace App\Controllers;

use Exception;
use Framework\Session;

class ManageArticlesController extends ArticlesController
{
    private array $userId;

    public function __construct()
    {
        parent::__construct();

        $this->userId = [
            'id' => Session::get('user')['id']
        ];
    }

    // -- AUTHOR USER --

    // DISPLAY ALL ACTIVE ARTICLES
    public function displayMyActiveArticlesPage(): void
    {
        $this->fetchArticles("`status` = 'active' AND `user_id` = :id", 'My active articles', $this->userId);        
    }

    // DISPLAY ALL PENDING ARTICLES
    public function displayMyPendingArticlesPage(): void
    {
        $this->fetchArticles("`status` = 'pending' AND `user_id` = :id", 'My pending articles', $this->userId);
    }

    public function submitNewArticlePage(): void
    {
        loadView('authorUser/submitNewArticle');
    }

    public function submitArticle(): void
    {
        (string) $title = isset($_POST['title']) ? $_POST['title'] : '';
        (string) $description = isset($_POST['description']) ? $_POST['description'] : '';
        (string) $section_one = isset($_POST['section_one']) ? $_POST['section_one'] : '';
        (string) $section_two = isset($_POST['section_two']) ? $_POST['section_two'] : null;
        (string) $section_three = isset($_POST['section_three']) ? $_POST['section_three'] : null;

        // check form data & display error if exist
        $errors = [];

        if (!isString($title, 5, 25)) {
            $errors['title'] = 'Please provide a valid title, between 5 and 25 characters';
        }
        if (!isString($description, 50, 250)) {
            $errors['description'] = 'Please provide a valid description, between 50 and 250 characters.';
        }
        if (!isString($section_one, 500, 2000)) {
            $errors['section_one'] = 'Please provide valid article content, between 500 and 2000 characters.';
        }
        if ($section_two && !isString($section_two, 500, 2000)) {
            $errors['section_two'] = 'Please provide valid article content, between 500 and 2000 characters.';
        }
        if ($section_three && !isString($section_three, 500, 2000)) {
            $errors['section_three'] = 'Please provide valid article content, between 500 and 2000 characters.';
        }

        if (!empty($errors)) {
            loadView('authorUser/submitNewArticle', [
                'errors' => $errors,
                'newArticle' => [
                    'title' => $title,
                    'description' => $description,
                    'section_one' => $section_one,
                    'section_two' => $section_two,
                    'section_three' => $section_three
                ]
            ]);
            return;
        }

        // if all is good -> submit article -> store in db
        (array) $newArticle = [
            'title' => $title,
            'description' => $description,
            'section_one' => $section_one,
            'section_two' => $section_two,
            'section_three' => $section_three,
            'created_at' => date("Y-m-d h:i:s"),
            'user_id' => $this->userId['id'],
            'status' => 'pending'
        ];

        try {
            $this->db->dbQuery("INSERT INTO articles (`title`, `description`, `section_one`, `section_two`,
            `section_three`, `created_at`, `user_id`, `status`) VALUES (:title, :description, :section_one, :section_two, :section_three, :created_at, :user_id, :status )", $newArticle);
        } catch (Exception $e) {
            ErrorController::randomError('Error while submitting article');
            return;
        }

        //redirect user 
        redirectUser('/my_pending_articles');
    }
}


