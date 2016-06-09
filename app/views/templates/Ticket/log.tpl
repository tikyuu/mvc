{include file="$_header_bootstrap"}
{include file="$_menu_ticket"}
<div class="container">
    <table class="table">
        <tbody>
            <tr>
                {foreach from=$ary_th item=v}
                <th>{$v}</th>
                {/foreach}
             </tr>
            {foreach from=$d2ary item=ary}
            <tr>
                {foreach from=$ary key=key item=v}
                <td>{$v}</td>
                {/foreach}
            {/foreach}
            </tr>
        </tbody>
    </table>
</div>