# テーブルresourceの生成
CREATE TABLE resource(
    code        char(6) primary key,
    name        varchar(40) NOT NULL,
    class       char(4) NOT NULL,
    price       int NOT NULL
);
  
# データの挿入
INSERT INTO resource VALUES('100001','英語テキスト','text',2500);
INSERT INTO resource VALUES('100002','数学テキスト','text',2700);
INSERT INTO resource VALUES('100003','国語テキスト','text',3000);
INSERT INTO resource VALUES('100101','英語DVD','mdvd',3000);
INSERT INTO resource VALUES('100102','数学学習ソフト','sftw',4900);
INSERT INTO resource VALUES('100103','英語学習ソフト','sftw',5400);
INSERT INTO resource VALUES('100201','国語副読本','sbtx',1200);
INSERT INTO resource VALUES('100202','英語問題集','pbbk',2500);
INSERT INTO resource VALUES('100203','数学問題集','pbbk',2800);
INSERT INTO resource VALUES('100C01','英語辞書','dict',8200);


#class_nameテーブルの生成
CREATE TABLE class_name(
    class       char(4) NOT NULL,
    name        varchar(10) NOT NULL
);
 
#データの挿入
INSERT INTO class_name VALUES('text','教科書');
INSERT INTO class_name VALUES('mdvd','マルチメディアDVD');
INSERT INTO class_name VALUES('sftw','ソフトウェア');
INSERT INTO class_name VALUES('sbtx','副読本');
INSERT INTO class_name VALUES('pbbk','問題集');
INSERT INTO class_name VALUES('dict','辞書');
INSERT INTO class_name VALUES('comp','コンピューター');
