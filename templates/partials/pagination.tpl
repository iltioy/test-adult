<nav class="pagination" aria-label="Пагинация">

    {if $page > 1}
        <a href="?sort={$sort}&page={$page-1}" class="pagination__link">← Назад</a>
    {/if}

    {for $i = 1 to $totalPages}
        <a href="?sort={$sort}&page={$i}"
           class="pagination__link{if $i === $page} pagination__link--active{/if}">
            {$i}
        </a>
    {/for}

    {if $page < $totalPages}
        <a href="?sort={$sort}&page={$page+1}" class="pagination__link">Вперёд →</a>
    {/if}

</nav>
