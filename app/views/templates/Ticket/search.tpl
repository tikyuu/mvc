
{include file="$_header_bootstrap"}
{include file="$_menu_ticket"}
<div class="container">
    <form method="post" action="{$send_file}">
        <!-- 分岐用 -->
        <input type="hidden" name="search"></input>

        <div class="row">
            <div class="col-sm-5">
                <div class="form-horizontal">
                    <h1>search</h1>

                    <!-- statuses -->
                    <div class="form-group">
                        <label for="status">ステータス: </label>
                        <select class="form-control" id="status" name="status">
                                <option value=""></option> <!-- default 空行 -->
                            {foreach from=$statuses item=item}
                                <option value="{$item.id}">{$item.name}</option>
                            {/foreach}
                        </select>
                    </div>

                    <!-- users -->
                    <div class="form-group">
                        <label for="user">担当者: </label>
                        <select class="form-control" id="user" name="user">
                            <option value=""></option> <!-- default 空行 -->
                        {foreach from=$users item=item}
                            <option value="{$item.id}">{$item.name}</option>
                        {/foreach}
                        </select>
                    </div>

                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" value="検索" name="button_other">
                        </div>  

                </div>
            </div>
            <dir class="col-sm-2"></dir> <!-- 間隔調整 -->
            <div class="col-sm-5">
                <!-- IDs -->
               <h1>ID search</h1> 
                <div class="form-group">
                    <label for="ticket_id">チケットID: </label>
                    <select class="form-control" id="ticket_id" name="ticket_id">
                        <option value=""></option> <!-- default 空行 -->
                    {foreach from=$ticket_ids item=item}
                        <option value="{$item}">{$item}</option>
                    {/foreach}
                    </select>
                </div>
                <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="検索" name="button_id">
                </div>
            </div>
        </div>
    </form>
</div>
