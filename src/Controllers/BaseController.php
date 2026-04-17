<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\SmartyFactory;

abstract class BaseController
{
    protected \Smarty $smarty;

    public function __construct()
    {
        $this->smarty = SmartyFactory::create();
    }

    protected function render(string $template, array $vars = []): void
    {
        $this->smarty->assign('currentYear', date('Y'));

        foreach ($vars as $key => $value) {
            $this->smarty->assign($key, $value);
        }

        $this->smarty->display($template);
    }

    protected function notFound(): void
    {
        http_response_code(404);
        $this->render('pages/404.tpl', ['title' => 'Страница не найдена']);
    }
}
