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
                        <!-- button -->
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


<!-- detail -->
<!-- <div class="modal fade" id="detailTest"><div class="modal-dialog"><div class="modal-content"><form method="post" action="send_file">

  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">
      <span aria-hidden="true">&times;</span>
    </button>
    <div class="form-group">
      <input type="hidden" name="id" value="id">
      <h3>ID: </h3>
    </div>
  </div>
  
  <div class="modal-body">
        <div class="form-group">
            <label for="status">ステータス: </label>
            <select class="form-control" id="status" name="status">
                    <option value="0">hoge</option>
            </select>
        </div>

        <div class="form-group">
            <label for="title">タイトル: </label>
            <input type="text" class="form-control" id="title" name="title" value="title">
        </div>
  
        <div class="form-group">
            <label for="description">内容: </label>
            <textarea class="form-control" id="description" name="description" rows="8">description</textarea>
        </div>
  </div>
  
  <div class="modal-footer">
    <div class="form-group">
      <input type="submit" class="btn btn-primary" name="update" value="決定">
      <div class="btn btn-default" data-dismiss="modal">戻る</button>
    </div>
  </div>

</form></div></div></div> -->


<div id="removeTest" class="modal fade">
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
                    <form method="post" action="/Ticket/check">
                        <input type="hidden" name="delete">
                        <input type="hidden" id="modal-id" name="id">
                        <input type="submit" class="btn btn-default" value="YES">
                        <div class="btn btn-default" data-dismiss="modal">NO</button>
                    </form>
            </div>
        </div>
    </div>
</div>



