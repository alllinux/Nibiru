<nav class="iconav">
    <a class="iconav-brand" href="/">
        <span class="icon icon-leaf iconav-brand-icon"></span>
    </a>
    <div class="iconav-slider">
        <ul class="nav nav-pills iconav-nav">
            {foreach $navigationJson as $naventry}
                <li >
                    {if $naventry.onclick}
                        <a title="{$naventry.tooltip}" data-toggle="tooltip" data-placement="right" data-container="body" onclick="{$naventry.onclick}">
                            <span class="{$naventry.icon}"></span>
                            <small class="iconav-nav-label visible-xs-block">{$naventry.title}</small>
                        </a>
                    {elseif $naventry.link}
                        <a href="{$naventry.link}" title="{$naventry.tooltip}" data-toggle="tooltip" data-placement="right" data-container="body">
                            <span class="{$naventry.icon}"></span>
                            <small class="iconav-nav-label visible-xs-block">{$naventry.title}</small>
                        </a>
                    {/if}
                </li>
            {/foreach}
        </ul>
    </div>
</nav>