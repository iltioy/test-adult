{extends file='layouts/base.tpl'}

{block name='content'}

    <h1 class="page-title">Последние статьи</h1>

    {foreach $categories as $category}
        <section class="category-section">

            <div class="category-section__header">
                <div>
                    <h2 class="category-section__title">
                        <a href="/category/{$category.slug}">{$category.name}</a>
                    </h2>
                    {if $category.description}
                        <p class="category-section__desc">{$category.description}</p>
                    {/if}
                </div>
                <a href="/category/{$category.slug}" class="btn btn--outline">Все статьи</a>
            </div>

            <div class="articles-grid">
                {foreach $category.articles as $article}
                    {include file='partials/article-card.tpl' article=$article}
                {/foreach}
            </div>

        </section>
    {foreachelse}
        <p class="empty-state">Статей пока нет. Запустите <code>php seed.php</code>.</p>
    {/foreach}

{/block}
