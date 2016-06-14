<!-- bootstrap -->
{include file="$_header_bootstrap"}
<!-- menu -->
{include file="$_menu_ticket"}

<!-- dummy test -->
<!-- { assign var="id" value="100"}
{ assign var="title" value="ほげ"}
{ assign var="description" value="嗚呼私、花なら咲くのに\n今私が吸い込んだ煙が\nどこにいくのかあなたは知らない\n\n抱きしめる手なんて\n選ばなければいくらでもあるわ\n私の平熱はあなたの微熱\n藍色の落ちる私の気持ち\n知りたいんでしょ\nめでたいのね\n嗚呼、テレキャスター・ストライプ\n押し寄せる波に"}
 -->
<!-- form -->
<div class="container"><div class="row"><div class="col-sm-6"><div class="form-horizontal">

<div style="padding:10px 10px 10px 10px"></div>
<h2>詳細</h2>
<div style="padding:10px 10px 10px 10px"></div>

    <form method="post" action="{$send_file}">
        <!-- id -->
        <div class="form-group">
            <input type="hidden" name="id" value="{$id}">
            <h3>ID: {$id}</h3>
        </div>
        <!-- title -->
        <div class="form-group">
            <label for="title">タイトル: </label>
            <input type="text" class="form-control" id="title" name="title" value="{$title}">
            </select>
        </div>
        <!-- description -->
        <div class="form-group">
            <label for="description">内容: </label>
            <textarea class="form-control" id="description" name="description" rows="8">{$description}</textarea>
            </select>
        </div>

        <div class="form-group">
            <input type="submit" class="btn btn-primary" name="update" value="決定">
            <input type="submit" class="btn btn-primary" value="戻る">
        </div>
    </form>

</div></div></div></div>