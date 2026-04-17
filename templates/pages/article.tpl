{extends file='layouts/base.tpl'}

{block name='content'}

    <article class="article">

        {if $article.image}
            <img class="article__image" src="{$article.image}" alt="{$article.title|escape}">
        {/if}

        <div class="article__meta">
            <span class="article__date">{$article.published_at|format_date}</span>
            <span class="article__views">{$article.views} просмотров</span>
            <div class="article__categories">
                {foreach $categories as $cat}
                    <a href="/category/{$cat.slug}" class="tag">{$cat.name}</a>
                {/foreach}
            </div>
        </div>

        <h1 class="article__title">{$article.title|escape}</h1>

        {if $article.description}
            <p class="article__description">{$article.description|escape}</p>
        {/if}

        <div class="article__text">
            {$article.text|escape|nl2br}
        </div>

    </article>

    {if $similar}
        <section class="similar">
            <h2 class="similar__title">Похожие статьи</h2>
            <div class="articles-grid">
                {foreach $similar as $article}
                    {include file='partials/article-card.tpl' article=$article}
                {/foreach}
            </div>
        </section>
    {/if}

{/block}
