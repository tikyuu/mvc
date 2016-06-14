create table search (
 number int(5) PRIMARY KEY AUTO_INCREMENT,
 name varchar(255) NOT NULL,
 address varchar(255),
 gender varchar(20) NOT NULL,
 skill varchar(255)
);
insert into search values(1, "山田　太郎", "東京都新宿区１２３", "男性", "営業");
insert into search values(2, "山田　次郎", "東京都新宿区１２３", "男性", "");
insert into search values(3, "春日　林太郎", "京都府紋所２５－１", "男性", "ワープロ/表計算/プログラミング/営業/音楽");
insert into search values(4, "鈴木　花子", "千葉県お台場２", "女性", "営業");
insert into search values(5, "田中　サチ子", "北海道稚内市ピーエイチビル５F", "女性", "ワープロ");
insert into search values(6, "佐藤　麗子", "アメリカアリゾナ州", "女性", "営業");
insert into search values(7, "中島　達夫", "東京都新宿区高田馬場９８７", "男性", "ワープロ/表計算/プログラミング");
insert into search values(8, "伊集院　鈴之介", "東京都田園調布５", "その他", "営業/音楽");
insert into search values(9, "藤田　田", "茨城県鹿島市９０", "男性", "表計算");
insert into search values(10, "孫　正義", "東京都大手町SBビル", "男性", "ワープロ");