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

                <th><div style="text-align:center;">execute</div></th>
            </tr>
            </div>
            {foreach from=$d2ary item=ary}
            <tr>
                {foreach from=$ary key=key item=v}
                <td><div style="text-align:center;">{$v}</div></td>
                {/foreach}
                <form method="post" action="/Ticket/check">
                    <!-- ticket ID -->
                    <input type="hidden" name="id" value="{$ary.id}"></input>
                    <!-- edit button -->
                    <td>
                    <div style="text-align:center;">
                        <button type="submit" class="btn btn-default" name="detail">
                            <i class="glyphicon glyphicon-pencil"></i>
                        </button>
                        <button type="submit" class="btn btn-default" name="delete">
                            <i class="glyphicon glyphicon-remove"></i>
                        </button>
                    </div>
                    </td>
                </form>
            {/foreach}
        </tbody>
    </table>
</div>