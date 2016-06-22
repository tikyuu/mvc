
# バグトラック test
__16/06/03 start__

## 参考
[Objective-PHP.net](http://www.objective-php.net/)  
[PHP で、spl_autoload_register を使って、require_once 地獄を脱出しよう](http://qiita.com/misogi@github/items/8d02f2eac9a91b4e6215)  
[jooto](https://www.jooto.com/)  
[PHP The Right Way](http://ja.phptherightway.com/)  
[PHPUnit 3.5.15: データベースのテストをする単純な例](https://gist.github.com/nissuk/1192791)  

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
    

## 画面
- ログイン
- ログアウト
- チケット ホーム
- チケット 追加
- チケット 検索
- チケット 編集
- チケット 削除(モーダルダイアログ)
- チケット ログ
- チケット アーカイブ


## mvc
```
例
http://localhost/Login/index/3
```
- `Login` -> LoginControllerクラス  
- `index` -> indexメソッド  
- `3` -> パラメータ (ページ数などで利用)  
- __全て'mvc/app/htdocs/index.php'から始まる__  
- urlに応じて画面を作成する


## sql

### ログイン画面

#### TABLE user
```sql
-- ログイン用。passwordはmd5で変換
CREATE TABLE user(
    id int NOT NULL AUTO_INCREMENT,
    name varchar(30) NOT NULL UNIQUE,
    password varchar(32) NOT NULL,
    PRIMARY KEY (id)
);
```

### チケット画面

#### TABLE status
```sql
-- 状態用。終了の場合、アーカイブで表示されるようになる。
create table status (
    id int not null auto_increment,
    name varchar(50) not null unique,
    primary key (id)
);

insert status (name) values ("新規");
insert status (name) values ("保留");
insert status (name) values ("終了");
```

#### TABLE log
```sql
-- チケット操作に対してのログ
CREATE TABLE log (
    id int not null auto_increment,
    ticket_id int not null,
    description text not null,
    time timestamp not null CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

#### TABLE ticket
```sql
-- チケット
CREATE TABLE ticket(
    id int(11) not null auto_increment,
    src_user_id int(11) not null,
    dst_user_id int(11) not null,
    title varchar(30) not null,
    description text not null,
    status int(11) not null,
    primary key (id)
);
```

## このデータをコピーした時の処理
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
あと各mysql接続用db,tableデータの追加が必要。


## todo
- ページネーションの作りが適当
- チケット ログ画面が適当
- DBの処理が適当
- DBTestの作成
- ...