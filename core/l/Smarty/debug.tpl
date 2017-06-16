{capture name='_smarty_debug' assign=debug_output}
    <h1>Smarty {Smarty::SMARTY_VERSION} Debug Console
        -  {if isset($template_name)}{$template_name|debug_print_var nofilter} {/if}{if !empty($template_data)}Total Time {$execution_time|string_format:"%.5f"}{/if}</h1>

    {if !empty($template_data)}
        <h2>included templates &amp; config files (load time in seconds)</h2>
        <div>
            {foreach $template_data as $template}
                <font color=brown>{$template.name}</font>
                <br>&nbsp;&nbsp;<span class="exectime">
                (compile {$template['compile_time']|string_format:"%.5f"}) (render {$template['render_time']|string_format:"%.5f"}) (cache {$template['cache_time']|string_format:"%.5f"})
                 </span>
                <br>
            {/foreach}
        </div>
    {/if}

    <h2>assigned template variables</h2>

    <table id="table_assigned_vars">
        {foreach $assigned_vars as $vars}
            <tr class="{if $vars@iteration % 2 eq 0}odd{else}even{/if}">
                <td><h3><font color=blue>${$vars@key}</font></h3>
                    {if isset($vars['nocache'])}<b>Nocache</b></br>{/if}
                    {if isset($vars['scope'])}<b>Origin:</b> {$vars['scope']|debug_print_var nofilter}{/if}
                </td>
                <td><h3>Value</h3>{$vars['value']|debug_print_var:10:80 nofilter}</td>
                <td>{if isset($vars['attributes'])}<h3>Attributes</h3>{$vars['attributes']|debug_print_var nofilter} {/if}</td>
         {/foreach}
    </table>

    <h2>assigned config file variables</h2>

    <table id="table_config_vars">
        {foreach $config_vars as $vars}
            <tr class="{if $vars@iteration % 2 eq 0}odd{else}even{/if}">
                <td><h3><font color=blue>#{$vars@key}#</font></h3>
                    {if isset($vars['scope'])}<b>Origin:</b> {$vars['scope']|debug_print_var nofilter}{/if}
                </td>
                <td>{$vars['value']|debug_print_var:10:80 nofilter}</td>
            </tr>
        {/foreach}

    </table>
{/capture}
<script type="text/javascript">
    {$id = '__Smarty__'}
    {if $display_mode}{$id = "$offset$template_name"|md5}{/if}

    document.write('{$debug_output|escape:'javascript' nofilter}');
    //_smarty_console = window.open("", "console{$id}", "width=1024,height=600,left={$offset},top={$offset},resizable,scrollbars=yes");
    //_smarty_console.document.write("{$debug_output|escape:'javascript' nofilter}");
    //_smarty_console.document.close();
</script>
