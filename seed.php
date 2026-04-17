<?php

declare(strict_types=1);

define('ROOT_DIR', __DIR__);

require ROOT_DIR . '/vendor/autoload.php';

date_default_timezone_set('UTC');

$_ENV['DB_HOST'] = getenv('DB_HOST') ?: 'mysql';
$_ENV['DB_NAME'] = getenv('DB_NAME') ?: 'blog';
$_ENV['DB_USER'] = getenv('DB_USER') ?: 'blog';
$_ENV['DB_PASS'] = getenv('DB_PASS') ?: 'blog';

$pdo = \App\Core\Database::getInstance();

$pdo->exec('SET FOREIGN_KEY_CHECKS = 0');
$pdo->exec('TRUNCATE TABLE article_categories');
$pdo->exec('TRUNCATE TABLE articles');
$pdo->exec('TRUNCATE TABLE categories');
$pdo->exec('SET FOREIGN_KEY_CHECKS = 1');

$categories = [
    [
        'name' => 'Технологии',
        'slug' => 'tekhnologii',
        'description' => 'Новости и обзоры из мира технологий: ИИ, программирование, гаджеты и цифровые тренды.',
    ],
    [
        'name' => 'Наука',
        'slug' => 'nauka',
        'description' => 'Научные открытия, исследования и достижения в различных областях знаний.',
    ],
    [
        'name' => 'Путешествия',
        'slug' => 'puteshestviya',
        'description' => 'Рассказы о путешествиях, советы туристам и интересные места по всему миру.',
    ],
    [
        'name' => 'Культура',
        'slug' => 'kultura',
        'description' => 'Кино, музыка, литература и другие проявления человеческого творчества.',
    ],
    [
        'name' => 'Спорт',
        'slug' => 'sport',
        'description' => 'События спортивного мира: соревнования, достижения спортсменов и советы по тренировкам.',
    ],
];

$categoryIds = [];
$stmt = $pdo->prepare('INSERT INTO categories (name, slug, description) VALUES (:name, :slug, :description)');

foreach ($categories as $cat) {
    $stmt->execute($cat);
    $categoryIds[$cat['slug']] = (int) $pdo->lastInsertId();
}

echo 'Создано категорий: ' . count($categories) . "\n";

$images = [
    'https://images.unsplash.com/photo-1518770660439-4636190af475?w=800',
    'https://images.unsplash.com/photo-1488590528505-98d2b5aba04b?w=800',
    'https://images.unsplash.com/photo-1485827404703-89b55fcc595e?w=800',
    'https://images.unsplash.com/photo-1451187580459-43490279c0fa?w=800',
    'https://images.unsplash.com/photo-1526779259212-939e64788e3c?w=800',
    'https://images.unsplash.com/photo-1498050108023-c5249f4df085?w=800',
    'https://images.unsplash.com/photo-1501854140801-50d01698950b?w=800',
    'https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?w=800',
    'https://images.unsplash.com/photo-1533107862482-0e6974b06ec4?w=800',
    'https://images.unsplash.com/photo-1526506118085-60ce8714f8c5?w=800',
    'https://images.unsplash.com/photo-1543269865-cbf427effbad?w=800',
    'https://images.unsplash.com/photo-1513128034602-7814ccaddd4e?w=800',
    'https://images.unsplash.com/photo-1532012197267-da84d127e765?w=800',
    'https://images.unsplash.com/photo-1573167507387-6b4b98cb7c13?w=800',
    'https://images.unsplash.com/photo-1604671801908-6f0c6a092c05?w=800',
    'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=800',
    'https://images.unsplash.com/photo-1546514714-df0ccc50d7bf?w=800',
    'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=800',
    'https://images.unsplash.com/photo-1509228468518-180dd4864904?w=800',
    'https://images.unsplash.com/photo-1516110833967-0b5716ca1387?w=800',
];

$lorem = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident.';

$articles = [
    [
        'title' => 'Искусственный интеллект в 2024 году: итоги и перспективы',
        'slug' => 'ii-2024-itogi',
        'description' => 'Обзор ключевых событий в мире ИИ: от GPT-4 до открытых моделей и регулирования.',
        'categories' => ['tekhnologii', 'nauka'],
    ],
    [
        'title' => 'Почему Rust становится языком системного программирования',
        'slug' => 'rust-sistemnoye-programmirovanie',
        'description' => 'Разбираем преимущества Rust перед C++ и почему крупные компании переходят на него.',
        'categories' => ['tekhnologii'],
    ],
    [
        'title' => 'Docker и контейнеризация: руководство для начинающих',
        'slug' => 'docker-rukovodstvo',
        'description' => 'Что такое контейнеры, зачем они нужны и как начать использовать Docker в своих проектах.',
        'categories' => ['tekhnologii'],
    ],
    [
        'title' => 'Квантовые компьютеры: реальность или маркетинг?',
        'slug' => 'kvantovye-kompyutery',
        'description' => 'Разбираемся, насколько квантовые вычисления близки к практическому применению.',
        'categories' => ['tekhnologii', 'nauka'],
    ],
    [
        'title' => 'Феномен стриминга: как изменилось кино',
        'slug' => 'fenomen-striminga',
        'description' => 'Как Netflix и Apple TV+ изменили способ создания и потребления кино.',
        'categories' => ['tekhnologii', 'kultura'],
    ],
    [
        'title' => 'Открытие нового вида динозавров в Аргентине',
        'slug' => 'novyy-vid-dinozavrov',
        'description' => 'Палеонтологи обнаружили останки одного из крупнейших существ, когда-либо живших на Земле.',
        'categories' => ['nauka'],
    ],
    [
        'title' => 'Как работает мозг: последние открытия нейронауки',
        'slug' => 'kak-rabotaet-mozg',
        'description' => 'Новые исследования раскрывают механизмы памяти, обучения и принятия решений.',
        'categories' => ['nauka'],
    ],
    [
        'title' => 'Изменение климата: что говорит наука',
        'slug' => 'izmenenie-klimata',
        'description' => 'Анализ последних научных данных об изменении климата и его последствиях для планеты.',
        'categories' => ['nauka'],
    ],
    [
        'title' => 'Шахматы в эпоху компьютеров: спорт или игра?',
        'slug' => 'shakhmaty-kompyutery',
        'description' => 'Как движки и ИИ изменили шахматы и что это значит для человеческих игроков.',
        'categories' => ['nauka', 'sport', 'tekhnologii'],
    ],
    [
        'title' => 'Токио за 7 дней: маршрут для первого визита',
        'slug' => 'tokio-7-dney',
        'description' => 'Подробный маршрут по японской столице с советами по транспорту, питанию и жилью.',
        'categories' => ['puteshestviya'],
    ],
    [
        'title' => 'Путешествие по Патагонии: на краю света',
        'slug' => 'patagonia-puteshestvie',
        'description' => 'Рассказ о походе по нетронутой природе Южной Америки: ледники, горы и тишина.',
        'categories' => ['puteshestviya'],
    ],
    [
        'title' => 'Лучшие пляжи Юго-Восточной Азии',
        'slug' => 'plyazhi-azii',
        'description' => 'Рейтинг лучших пляжей Таиланда, Вьетнама, Индонезии и Малайзии.',
        'categories' => ['puteshestviya', 'kultura'],
    ],
    [
        'title' => 'Как путешествовать с ограниченным бюджетом',
        'slug' => 'byudzhetnoye-puteshestvie',
        'description' => 'Практические советы по экономии на перелётах, жилье и питании в любой точке мира.',
        'categories' => ['puteshestviya'],
    ],
    [
        'title' => 'Исландия зимой: северное сияние и горячие источники',
        'slug' => 'islandiya-zima',
        'description' => 'Почему зима — лучшее время для поездки в Исландию и как это организовать.',
        'categories' => ['puteshestviya'],
    ],
    [
        'title' => 'Лучшие книги 2024 года: наш выбор',
        'slug' => 'luchshie-knigi-2024',
        'description' => 'Десять книг, которые стоит прочитать: от детективов до научпопа.',
        'categories' => ['kultura'],
    ],
    [
        'title' => 'Возрождение vinyl: почему люди снова слушают пластинки',
        'slug' => 'vozrozhdenie-vinyl',
        'description' => 'В эпоху стриминга продажи виниловых пластинок бьют рекорды. Почему?',
        'categories' => ['kultura'],
    ],
    [
        'title' => 'Олимпиада 2024: медальный зачёт и главные впечатления',
        'slug' => 'olimpiada-2024',
        'description' => 'Итоги Олимпийских игр: рекорды, сюрпризы и самые запоминающиеся моменты.',
        'categories' => ['sport'],
    ],
    [
        'title' => 'Как начать бегать: план на первые 8 недель',
        'slug' => 'kak-nachat-begat',
        'description' => 'Структурированный план тренировок для тех, кто хочет начать бегать с нуля.',
        'categories' => ['sport'],
    ],
    [
        'title' => 'Формула 1: революция в технологиях безопасности',
        'slug' => 'formula-1-bezopasnost',
        'description' => 'Как технологии Формулы 1 спасают жизни гонщиков и меняют автомобильную индустрию.',
        'categories' => ['sport', 'tekhnologii'],
    ],
    [
        'title' => 'Питание для тренировок: что есть до и после занятий',
        'slug' => 'pitanie-trenirovki',
        'description' => 'Научно обоснованные рекомендации по питанию для повышения спортивных результатов.',
        'categories' => ['sport', 'nauka'],
    ],
];

$stmtArticle = $pdo->prepare(
    'INSERT INTO articles (title, slug, description, text, image, views, published_at)
     VALUES (:title, :slug, :description, :text, :image, :views, :published_at)'
);
$stmtAC = $pdo->prepare(
    'INSERT INTO article_categories (article_id, category_id) VALUES (:article_id, :category_id)'
);

$date = new DateTime('2024-01-01');

foreach ($articles as $i => $article) {
    $date->modify('+' . rand(3, 12) . ' days');

    $text = $article['description'] . "\n\n" . $lorem . "\n\n" . $lorem . "\n\n" . $lorem;

    $stmtArticle->execute([
        'title' => $article['title'],
        'slug' => $article['slug'],
        'description' => $article['description'],
        'text' => $text,
        'image' => $images[$i % count($images)],
        'views' => rand(10, 3000),
        'published_at' => $date->format('Y-m-d H:i:s'),
    ]);

    $articleId = (int) $pdo->lastInsertId();

    foreach ($article['categories'] as $catSlug) {
        $stmtAC->execute([
            'article_id' => $articleId,
            'category_id' => $categoryIds[$catSlug],
        ]);
    }
}

echo 'Создано статей: ' . count($articles) . "\n";
echo "Сидинг завершён успешно.\n";
