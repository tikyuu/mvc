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
                        <div class="btn btn-default" data-toggle="modal" data-target="#removeTest" data-remove-text="#{$ary.id} {$ary.title}" data-remove-id="{$ary.id}">
                            <i class="glyphicon glyphicon-remove"></i>
                        </div>
                    </div>
                    </td>
                </form>
            {/foreach}
        </tbody>
    </table>
</div>

<!-- delete modal dialog -->
<script>
    $(function () {
        $('#removeTest').on('show.bs.modal', function (event) {
            var text = $(event.relatedTarget).data('remove-text');
            $('#show-modal').text(text);
            var id = $(event.relatedTarget).data('remove-id');
            $('#modal-id').val(id);
        });

    });
</script>
<div class="modal fade" id="removeTest" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
                <span id="show-modal"></span>
                <h4 class="modal-title" id="modal-label"></h4>
            </div>
            <div class="modal-body">
                本当に削除してよろしいですか？
            </div>
            <div class="modal-footer">
                <!-- <div style="text-align:center;"> -->
                    <form method="post" action="/Ticket/check">
                        <input type="hidden" name="delete">
                        <input type="hidden" id="modal-id" name="id">
                        <input type="submit" class="btn btn-default" value="YES">
                        <div class="btn btn-default" data-dismiss="modal">NO</button>
                    </form>
                <!-- </div> -->
            </div>
        </div>
    </div>
</div>