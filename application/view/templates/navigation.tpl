<nav class="iconav">
    <a class="iconav-brand" href="/">
        <span class="icon icon-leaf iconav-brand-icon"></span>
    </a>
    <div class="iconav-slider">
        <ul class="nav nav-pills iconav-nav">
            {foreach $navigationJson as $naventry}
                <li >
                    <a href="{$naventry.link}" title="{$naventry.tooltip}" data-toggle="tooltip" data-placement="right" data-container="body">
                        <span class="icon {$naventry.icon}"></span>
                        <small class="iconav-nav-label visible-xs-block">{$naventry.title}</small>
                    </a>
                </li>
            {/foreach}
        </ul>
    </div>
</nav>