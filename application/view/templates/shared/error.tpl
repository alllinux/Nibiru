<!DOCTYPE html>
<html class="no-js" lang="de">
<head>
    <title>{$errorTitle|default:'Seite nicht gefunden'} | Maschinen Stockert</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="robots" content="{$metaRobots|default:'noindex, follow'}">
    <meta name="description" content="{$errorMessage|default:'Die angeforderte Seite konnte leider nicht gefunden werden.'}">
    {foreach item=style from=$css}
        <link href="{$style.path}"{foreach from=$style.css key=k item=v} {$k}="{$v}"{/foreach}>
    {/foreach}
    <link rel="shortcut icon" href="/public/front/maschinen-stockert.de/images/v4/favicon.png" sizes="72x72">
</head>
<body data-mobile-nav-style="classic">

<!-- 404 ERROR PAGE CONTENT START -->
<section class="bg-light-gray padding-120px-tb lg-padding-90px-tb md-padding-75px-tb sm-padding-50px-tb" style="min-height: 100vh; display: flex; align-items: center;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8 text-center">
                <div class="error-page-content">
                    <!-- Logo -->
                    <div class="margin-50px-bottom">
                        <a href="/">
                            <img src="/public/front/maschinen-stockert.de/img/logos/MaschinenStockertLogo.svg"
                                 alt="Maschinen Stockert"
                                 style="max-width: 250px; height: auto;">
                        </a>
                    </div>

                    <!-- Error Code -->
                    <h1 class="alt-font font-weight-700 text-slate-blue margin-30px-bottom" style="font-size: 150px; line-height: 1;">
                        {$errorCode|default:'404'}
                    </h1>

                    <!-- Error Title -->
                    <h2 class="alt-font font-weight-500 text-extra-dark-gray margin-20px-bottom" style="font-size: 28px;">
                        {$errorTitle|default:'Seite nicht gefunden'}
                    </h2>

                    <!-- Error Message -->
                    <p style="font-size: 18px; line-height: 1.6; color: #6c757d; margin-bottom: 20px;">
                        {$errorMessage|default:'Die angeforderte Seite konnte leider nicht gefunden werden.'}
                    </p>

                    <!-- Error Suggestion -->
                    <p style="font-size: 14px; color: #999; margin-bottom: 30px;">
                        {$errorSuggestion|default:'Die Seite wurde möglicherweise verschoben, gelöscht oder existiert nicht mehr.'}
                    </p>

                    {* Show requested URL for reference *}
                    {if $requestedUri}
                    <p style="font-size: 12px; color: #aaa; margin-bottom: 40px;">
                        <span style="color: #333;">Angeforderte URL:</span>
                        <code style="background: #f5f5f5; padding: 2px 8px; border-radius: 3px; font-family: monospace;">{$requestedUri}</code>
                    </p>
                    {/if}

                    <!-- Action Buttons -->
                    <div style="margin-top: 40px;">
                        <a href="{$homeUrl|default:'/'}"
                           style="display: inline-block; padding: 12px 30px; background: #333; color: #fff; text-decoration: none; border-radius: 4px; margin: 5px; font-weight: 500;">
                            Zur Startseite
                        </a>
                        <a href="{$machinesUrl|default:'/maschinen'}"
                           style="display: inline-block; padding: 12px 30px; background: transparent; color: #333; text-decoration: none; border: 1px solid #333; border-radius: 4px; margin: 5px; font-weight: 500;">
                            Maschinen
                        </a>
                        <a href="{$contactUrl|default:'/kontakt'}"
                           style="display: inline-block; padding: 12px 30px; background: transparent; color: #333; text-decoration: none; border: 1px solid #333; border-radius: 4px; margin: 5px; font-weight: 500;">
                            Kontakt
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- 404 ERROR PAGE CONTENT END -->

<!-- Minimal scripts -->
{foreach item=script from=$js}
    <script src="{$script.path}" type="{$script.js.type|default:'text/javascript'}"{if isset($script.js.defer) && $script.js.defer} defer{/if}></script>
{/foreach}
</body>
</html>
