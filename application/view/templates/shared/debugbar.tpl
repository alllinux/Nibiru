{if $debuging==true}
    <script>
        $( function() {
            $( "#tabs" ).tabs();
        } );
    </script>
<div id="nibiru-bar-open" class="closed">
    <span class="nibiru-bar-logo"></span>
    <p>{$ndbinfo}</p>
</div>
<div id="nibiru-debug" class="down">
    <div id="tabs">
        <ul>
            <li><a href="#tabs-1">$_POST</a></li>
            <li><a href="#tabs-2">$_GET</a></li>
            <li><a href="#tabs-3">$_REQUEST</a></li>
            <li><a href="#tabs-4">$_SERVER</a></li>
            <li><a href="#tabs-5">$_ENV</a></li>
            <li><a href="#tabs-6">$_FILES</a></li>
            <li><a href="#tabs-7">$_COOKIE</a></li>
            <li><a href="#tabs-8">$_SESSION</a></li>
            <li><a href="#tabs-9">$GLOBALS</a></li>
            <li><a href="#tabs-10">SMARTY Engine</a></li>
            <li><a href="#tabs-11">Messages</a></li>
        </ul>
        {assign var="message" value="ERROR: no message defined!"}
        <div id="tabs-1">
            <p>
                <!-- Smarty $_POST output -->
                {if isset($ndbpost)}
                    {$ndbpost}
                {else}
                    {$message}
                {/if}
            </p>
        </div>
        <div id="tabs-2">
            <p>
                <!-- Smarty $_GET output -->
                {if isset($ndbget)}
                    {$ndbget}
                {else}
                    {$message}
                {/if}
            </p>
        </div>
        <div id="tabs-3">
            <p>
                <!-- Smarty $_REQUEST output -->
                {if isset($ndbrequest)}
                    {$ndbrequest}
                {else}
                    {$message}
                {/if}
            </p>
        </div>
        <div id="tabs-4">
            <p>
                <!-- Smarty $_SERVER output -->
                {if isset($ndbserver)}
                    {$ndbserver}
                {else}
                    {$message}
                {/if}
            </p>
        </div>
        <div id="tabs-5">
            <p>
                <!-- Smarty $_ENV output -->
                {if isset($ndbenv)}
                    {$ndbenv}
                {else}
                    {$message}
                {/if}
            </p>
        </div>
        <div id="tabs-6">
            <p>
                <!-- Smarty $_FILES output -->
                {if isset($ndbfiles)}
                    {$ndbfiles}
                {else}
                    {$message}
                {/if}
            </p>
        </div>
        <div id="tabs-7">
            <p>
                <!-- Smarty $_COOKIE output -->
                {if isset($ndbcookie)}
                    {$ndbcookie}
                {else}
                    {$message}
                {/if}
            </p>
        </div>
        <div id="tabs-8">
            <p>
                <!-- Smarty $_SESSION output -->
                {if isset($ndbsession)}
                    {$ndbsession}
                {else}
                    {$message}
                {/if}
            </p>
        </div>
        <div id="tabs-9">
            <p>
                <!-- Smarty $GLOBALS output -->
                {if isset($ndbglobals)}
                    {$ndbglobals}
                {else}
                    {$message}
                {/if}
            </p>
        </div>
        <div id="tabs-10">
            {debug}
        </div>
        <div id="tabs-11">
            <p>
                <!-- Smarty $raw output -->
                {if isset($ndbraw_output)}
                <pre>
                    {$ndbraw_output}
                </pre>
                {else}
                    {$message}
                {/if}
            </p>
        </div>
    </div>
</div>
{/if}