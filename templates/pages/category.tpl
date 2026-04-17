{extends file='layouts/base.tpl'}

{block name='content'}

    <div class="page-header">
        <h1 class="page-title">{$category.name}</h1>
        {if $category.description}
            <p class="page-desc">{$category.description}</p>
        {/if}
    </div>

    <div class="sort-bar">
        <span class="sort-bar__label">Сортировка:</span>
        <a href="?sort=date"  class="sort-bar__link{if $sort === 'date'} sort-bar__link--active{/if}">По дате</a>
        <a href="?sort=views" class="sort-bar__link{if $sort === 'views'} sort-bar__link--active{/if}">По просмотрам</a>
    </div>

    {if $articles}

        <div class="articles-grid">
            {foreach $articles as $article}
                {include file='partials/article-card.tpl' article=$article}
            {/foreach}
        </div>

        {if $totalPages > 1}
            {include file='partials/pagination.tpl' page=$page totalPages=$totalPages sort=$sort}
        {/if}

    {else}
        <p class="empty-state">В этой категории пока нет статей.</p>
    {/if}

{/block}
