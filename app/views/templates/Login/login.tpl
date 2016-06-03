{include file="$_header_bootstrap"}

<div class="container" style="padding:40px 10px 10px 10px">
    <h1>ログイン画面</h1>
    <div style="padding-top:30px">
        <form method="post" action="{$send_file}">
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <div class="form-group">
                            <label for="{$res_1}">ユーザ名: </label>
                            <input type="text" class="form-control" id="{$res_1}" name="{$res_1}">
                        </div>
                        <div class="form-group">
                            <label for="{$res_2}">パスワード: </label>
                            <input type="password" class="form-control" id="{$res_2}" name="{$res_2}">
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" value="送信">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
