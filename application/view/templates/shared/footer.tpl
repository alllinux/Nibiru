{foreach item=script from=$js}
    <script src="{$script}"></script>
{/foreach}
<script>
    // execute/clear BS loaders for docs
    $(function(){
        while( window.BS&&window.BS.loader&&window.BS.loader.length )
        {
            (window.BS.loader.pop())()
        }
    })
</script>
{include file="./debugbar.tpl"}