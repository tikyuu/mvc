
{include file="$_header_bootstrap"}
{include file="$_menu_ticket"}
<div class="container">
    <h1>search</h1>
    <form method="post" action="{$send_file}">
        <!-- 分岐用 -->
        <input type="hidden" name="search"></input>

        <div class="row">
            <div class="col-sm-4">
                <div class="form-horizontal">
                    <div class="form-group">
                        <label for="id">id: </label>
                            <input type="text" class="form-control" id="id" name="id">
                    </div>

                    <div class="form-group">
                        <label for="title">題名: </label>
                        <input type="text" class="form-control" id="title" name="title">
                    </div>
                    <div class="form-group">
                        <label for="description">本文: </label>
                        <input type="text" class="form-control" id="description" name="description">
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="OR検索" name="or">
                        <input type="submit" class="btn btn-primary" value="AND検索" name="and">
                    </div>  

                </div>
            </div>
        </div>
    </form>
</div>
