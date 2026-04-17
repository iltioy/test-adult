# Blog — тестовое задание

PHP 8.1 / Smarty / MySQL / Docker

---

## Требования

- [Docker Desktop](https://www.docker.com/products/docker-desktop/) (включает Docker Compose)
- Порты **8081** и **3306** должны быть свободны

---

## Быстрый старт

```bash
# 1. Клонировать / распаковать проект
cd adult-test

# 2. Поднять контейнеры (nginx + php-fpm + mysql)
make up
# или без make:
docker-compose up -d --build
```

Первый запуск занимает ~1–2 минуты: Docker скачивает образы, устанавливает Composer-зависимости и компилирует SCSS.

```bash
# 3. Наполнить базу тестовыми данными
make seed
# или:
docker-compose exec php php seed.php
```

```bash
# 4. Открыть сайт
http://localhost:8081
```

---

## Страницы

| URL | Описание |
|-----|----------|
| `http://localhost:8081/` | Главная — категории с 3 последними статьями каждой |
| `http://localhost:8081/category/{slug}` | Страница категории со списком статей |
| `http://localhost:8081/article/{slug}` | Страница отдельной статьи |

**Примеры категорий после сидинга:**

| Slug | Категория |
|------|-----------|
| `tekhnologii` | Технологии |
| `nauka` | Наука |
| `puteshestviya` | Путешествия |
| `kultura` | Культура |
| `sport` | Спорт |

Пример: `http://localhost:8081/category/tekhnologii`

---

## Функционал для проверки

### Главная страница
- Отображаются только категории, в которых есть статьи
- В каждой категории — 3 последних поста (по дате публикации)
- Кнопка «Все статьи» ведёт на страницу категории

### Страница категории
- Название и описание категории
- Список статей с пагинацией (6 статей на страницу)
- Сортировка через параметр `?sort=date` (по умолчанию) или `?sort=views`

### Страница статьи
- Полная информация: изображение, название, описание, текст, категории, дата, просмотры
- Счётчик просмотров увеличивается при каждом открытии
- Блок «Похожие статьи» — 3 случайные статьи из тех же категорий

---

## Управление

```bash
make up       # Запустить (с пересборкой)
make down     # Остановить
make restart  # Перезапустить php и nginx
make seed     # Заполнить базу данными
make logs     # Смотреть логи в реальном времени
```

---

## Структура проекта

```
adult-test/
├── public/          # Точка входа (index.php) + скомпилированный CSS
├── src/
│   ├── Controllers/ # HomeController, CategoryController, ArticleController
│   ├── Core/        # Router, Database (PDO singleton), SmartyFactory
│   └── Models/      # Article, Category
├── templates/       # Smarty-шаблоны (.tpl)
│   ├── layouts/     # Базовый layout (base.tpl)
│   ├── pages/       # home, category, article, 404
│   └── partials/    # article-card, pagination
├── scss/            # Исходные SCSS-файлы
├── db/              # schema.sql — инициализация БД
├── docker/          # Dockerfile для PHP, конфиг nginx
├── seed.php         # Скрипт сидинга
└── docker-compose.yml
```

---

## Технологический стек

- **PHP 8.1** (php-fpm, alpine)
- **Smarty 4.3** — шаблонизатор
- **MySQL 8.0**
- **Nginx 1.25**
- **scssphp** — компиляция SCSS в CSS при старте контейнера
- **Docker Compose** — оркестрация
