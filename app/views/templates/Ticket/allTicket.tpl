<!-- bootstrap -->
{include file="$_header_bootstrap"}
<!-- menu -->
{include file="$_menu_ticket"}
<!-- pagenation -->
{include file="$_pagenation_ticket"}
<!-- table -->
<div class="container">
    <table class="table table-striped">
        <tbody>
            <tr>
                {foreach from=$ary_th item=v}
                <th><div style="text-align:center;">{$v}</div></th>
                {/foreach}
             </tr>
            {foreach from=$d2ary item=ary}
            <tr>
                {foreach from=$ary key=key item=v}
                <td><div style="text-align:center;">{$v}</div></td>
                {/foreach}
            {/foreach}
            </tr>
        </tbody>
    </table>
</div>