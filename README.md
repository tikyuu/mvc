# mvc

初MVC挑戦  

## 16/06/03
[Objective-PHP.net](http://www.objective-php.net/)を参考にログイン画面作成。

## 今後
- todo作成。
- まだmvcしかやってない。
- DBでのトランザクション
- 複数テーブルでの結合。
- ログイン画面の設定を強化。クッキーをどうにかする。
- 各ユーザ画面作成。
- 各ユーザからチケットの受け渡しを行う。
- web用バグトラックの完成。



## PDO 
### 必ずtry-catchを書く

### ユーザ入力を伴わない場合
ユーザ入力を伴わないクエリは単にPDO::queryメソッドを実行。戻り値はPDOStatement  
またはPDO::execを使用。  
```php
$state = $pdo->query('SELECT * FROM people');

// or
$count = $pdo->exec('UPDATE people SET age = age + 1');
```

### ユーザ入力を伴う
PDO::prepare -> PDOStatement::bindValue -> PDOStatement::executeの３ステップでクエリを実行  
プリペアドステートメント -> プレースホルダ  

## apache
httpd.conf
```apache

# AllowOverride controls what directives may be placed in .htaccess files.
# it can be "All", "None", or any combination of the keywords:
# Options FileInfo Authconfig Limit
#
AllowOverride None #　Allへ変更

...

<VirtualHost *>
    DocumentRoot /var/www/html/mvc/app/htdocs # root指定
</VirtualHost>

```