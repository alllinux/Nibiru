<!-- This file is just for an idea of the integration concerning a pagination -->
<div class="pagination">
    <ul>
        <li class="prev"><a href="{$pagination.paginationPath}{$pagination.previous}"><i class="pe-7s-angle-left pe-2x"></i></a></li>
        {foreach item=page from=$pagination key="key"}
            {if $key|@is_numeric}
                {if $page.page==$pagination.current}
                    <li class="active"><a href="{$pagination.paginationPath}{$page.page}">{$page.page}</a></li>
                    {else}
                    <li><a href="{$pagination.paginationPath}{$page.page}">{$page.page}</a></li>
                {/if}
            {/if}
        {/foreach}
        <li class="next"><a href="{$pagination.paginationPath}{$pagination.next}"><i class="pe-7s-angle-right pe-2x"></i></a></li>
    </ul>
</div>