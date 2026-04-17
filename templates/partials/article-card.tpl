<article class="card">
    {if $article.image}
        <a href="/article/{$article.slug}" class="card__image-link">
            <img class="card__image" src="{$article.image}" alt="{$article.title|escape}" loading="lazy">
        </a>
    {/if}
    <div class="card__body">
        <h3 class="card__title">
            <a href="/article/{$article.slug}">{$article.title|escape}</a>
        </h3>
        {if $article.description}
            <p class="card__desc">{$article.description|escape|truncate:110:'...'}</p>
        {/if}
        <div class="card__footer">
            <span class="card__date">{$article.published_at|format_date}</span>
            <span class="card__views">{$article.views} просм.</span>
        </div>
    </div>
</article>
