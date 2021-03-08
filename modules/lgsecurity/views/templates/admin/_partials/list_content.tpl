{if empty($lgsecurity_list)}
<tr>
    <td colspan="4">
        {l s='There are no detected items' mod='lgsecurity'}
    </td>
</tr>
{else}
    {foreach from=$lgsecurity_list item=elemento name=lgsecuritylist}
        <tr{if $smarty.foreach.lgsecuritylist.index % 2 == 0} class="odd"{/if}>
            <td>
                {$elemento['path']}
            </td>
            <td>
                {if $elemento['status'] == 'detected'}<i class="icon-warning" style="display:inline-block; color: red;"></i> {/if}{$elemento['status']}
            </td>
            <td>
                {$elemento['date_add']}
            </td>
            <td>
                <span class="lgsecurityDelteItemButton" data-id="{$elemento['id_lgsecurity_stack']}"><i class="icon-trash"></i></span>
            </td>
        </tr>
    {/foreach}
{/if}
