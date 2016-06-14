<!-- bootstrap -->
{include file="$_header_bootstrap"}
<!-- menu -->
{include file="$_menu_ticket"}
<!-- pagenation -->
{include file="$_pagenation_ticket"}
<!-- table -->
<div class="container">
    <table class="table">
        <tbody>
            <tr>
                {foreach from=$ary_th item=v}
                <th>{$v}</th>
                {/foreach}
                <!-- <th>edit</th> -->
            </tr>
            {foreach from=$d2ary item=ary}
            <tr>
                {foreach from=$ary key=key item=v}
                <td>{$v}</td>
                {/foreach}
                <form method="post" action="/Ticket/check">
                    <!-- ticket ID -->
                    <input type="hidden" name="id" value="{$ary.id}"></input>
                    <!-- edit button -->
                    <td>
                        <button type="submit" class="btn btn-default" name="edit">
                            <i class="glyphicon glyphicon-pencil"></i>
                        </button>
                    </td>
                    <!-- delete button -->
                    <td>
                        <button type="submit" class="btn btn-default" name="delete">
                            <i class="glyphicon glyphicon-remove"></i>
                        </button>
                    </td>
                </form>
            {/foreach}
        </tbody>
    </table>
</div>
