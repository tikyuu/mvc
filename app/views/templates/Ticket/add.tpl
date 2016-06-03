{include file="$_header_bootstrap"}

<div class="container">
    <h1>add_ticket</h1>
    <form method="post" action="{$send_file}">
        <div class="row">
            <div class="col-sm-6">
                <div class="form-horizontal">
                    <div class="form-group">
                        <label for="label">ラべル</label>
                        <select class="form-control" id="label" name="label">
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="status">ステータス</label>
                        <select class="form-control" id="status" name="status">
                        <option>status1</option>
                        <option>status2</option>
                        <option>status3</option>
                        <option>status4</option>
                        <option>status5</option>
                        <option>status6</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="dst_user">担当者: </label>
                        <input type="text" class="form-control" id="dst_user" name="dst_user" placeholder="新垣">
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="title">題名: </label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="hoge">
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="describe">本文: </label>
                        <textarea class="form-control" id="describe" name="describe" rows="8" placeholder="hello world!"></textarea>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="open_date">開始日: </label>
                        <input type="text" class="form-control" id="open_date" name="open_date" placeholder="hoge">
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="close_date">終了日: </label>
                        <input type="text" class="form-control" id="close_date" name="close_date" placeholder="hoge">
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
