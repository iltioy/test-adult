<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Category;

class HomeController extends BaseController
{
    public function index(array $params): void
    {
        $this->render('pages/home.tpl', [
            'title' => 'Главная',
            'categories' => Category::getAllWithLatestArticles(3),
        ]);
    }
}
