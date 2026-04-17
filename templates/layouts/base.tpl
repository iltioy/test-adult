<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{$title|default:'Блог'} — МойБлог</title>
    <link rel="stylesheet" href="/assets/css/main.css">
</head>
<body>

<header class="header">
    <div class="container">
        <a href="/" class="header__logo">МойБлог</a>
    </div>
</header>

<main class="main">
    <div class="container">
        {block name='content'}{/block}
    </div>
</main>

<footer class="footer">
    <div class="container">
        <p class="footer__text">© {$currentYear} МойБлог</p>
    </div>
</footer>

</body>
</html>
