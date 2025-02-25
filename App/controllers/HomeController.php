<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\ArticlesModels;

class HomeController extends ArticlesModels
{
    public function latestArticles(): void
    {
        $updatedQuery = "`status` = 'active' ORDER BY created_at DESC LIMIT 3";

        $articles = $this->fetchArticles($updatedQuery);

        loadView('home', [
            'articles' => $articles ?? ''
        ]);
    }
}
