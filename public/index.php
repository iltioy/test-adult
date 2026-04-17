<?php

declare(strict_types=1);

use App\Controllers\ArticleController;
use App\Controllers\CategoryController;
use App\Controllers\HomeController;
use App\Core\Router;
use App\Core\SmartyFactory;

define('ROOT_DIR', dirname(__DIR__));

require ROOT_DIR . '/vendor/autoload.php';

date_default_timezone_set('UTC');

set_exception_handler(static function (\Throwable $e): void {
    http_response_code(500);
    error_log($e->getMessage());
    echo '<h1>500 — Внутренняя ошибка сервера</h1>';
});

$_ENV['DB_HOST'] = getenv('DB_HOST') ?: 'mysql';
$_ENV['DB_NAME'] = getenv('DB_NAME') ?: 'blog';
$_ENV['DB_USER'] = getenv('DB_USER') ?: 'blog';
$_ENV['DB_PASS'] = getenv('DB_PASS') ?: 'blog';

$router = new Router();
$router->add('GET', '/', HomeController::class, 'index');
$router->add('GET', '/category/{slug}', CategoryController::class, 'show');
$router->add('GET', '/article/{slug}', ArticleController::class, 'show');

if (!$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI'])) {
    http_response_code(404);
    $smarty = SmartyFactory::create();
    $smarty->assign('currentYear', date('Y'));
    $smarty->assign('title', 'Страница не найдена');
    $smarty->display('pages/404.tpl');
}
