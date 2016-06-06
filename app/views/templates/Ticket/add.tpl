{include file="$_header_bootstrap"}

<div class="container">
    <h1>add_ticket</h1>
    <form method="post" action="{$send_file}">
        <!-- 分岐用 -->
        <input type="hidden" name="add"></input>
        <!-- 自身 -->
        <input type="hidden" name="src_user" value="新垣"></input>

        <div class="row">
            <div class="col-sm-6">
                <div class="form-horizontal">

                    <div class="form-group">
                        <label for="label">ラべル</label>
                        <select class="form-control" id="label" name="label">
                        {foreach from=$labels item=item}
                            <option>{$item}</option>
                        {/foreach}
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="status">ステータス</label>
                        <select class="form-control" id="status" name="status">
                        {foreach from=$statuses item=item}
                            <option>{$item}</option>
                        {/foreach}
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="dst_user">担当者: </label>
                        <select class="form-control" id="dst_user" name="dst_user">
                        {foreach from=$dst_user item=item}
                            <option>{$item}</option>
                        {/foreach}
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="title">題名: </label>
                        <input type="text" class="form-control" id="title" name="title">
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="description">※本文: </label>
                        <textarea class="form-control" id="description" name="description" rows="8"></textarea>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="open_date">開始日: </label>
                        <input type="text" class="form-control" id="open_date" name="open_date" placeholder="{$open_date}">
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="close_date">終了日: </label>
                        <input type="text" class="form-control" id="close_date" name="close_date">
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="追加">
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
