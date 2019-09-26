
# PHP 勉強用

[Objective-PHP.net](http://www.objective-php.net/)  
[PHP The Right Way](http://ja.phptherightway.com/)  


## version
- PHP 5.6.22
- Apache 2.2.15
- mysql 5.1.73
- composer 1.1.2

## 階層
- mvc(root)
    - app               - mvc各ソースコード
    - library           - 汎用的なソースコード
    - log               - ログ
    - sql               - sqlテーブル確認用
    - tests         - ユニットテスト用(PHPUnit)
    - vendor        - phpライブラリ管理用(ユニットテスト,smartyなど)

## ルーティング
```
例
http://localhost/Login/index/3
```
- `Login` -> LoginControllerクラス  
- `index` -> indexメソッド  
- `3` -> パラメータ (ページ数などで利用)  
- __全て'mvc/app/htdocs/index.php'から始まる__  
- urlに応じて画面を作成する

## 設定
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

views
```bash
# viewsにファイル生成があるので管理者をapacheに変更
chown apache:apache -R mvc/app/views
```
mysql接続用db,tableデータの追加が必要。

