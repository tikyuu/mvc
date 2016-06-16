CREATE TABLE ticket(
    id int(11) not null auto_increment,
    src_user_id int(11) not null,
    dst_user_id int(11) not null,
    title varchar(30) not null,
    description text not null,
    status int(11) not null,
    primary key (id)
);

# INSERT INTO ticket (src_user, dst_user, description) VALUES (1, 1, "test");
INSERT ticket (src_user_id, dst_user_id, title, description, status) VALUES (3, 3, "十年後の約束", "三秋縋", 1);
INSERT ticket (src_user_id, dst_user_id, title, description, status) VALUES (3, 3, "終わりの始まり", "三秋縋", 1);
INSERT ticket (src_user_id, dst_user_id, title, description, status) VALUES (3, 3, "三角座りの監視員", "三秋縋", 1);
INSERT ticket (src_user_id, dst_user_id, title, description, status) VALUES (3, 3, "答え合わせといきましょう", "三秋縋", 1);
INSERT ticket (src_user_id, dst_user_id, title, description, status) VALUES (3, 3, "これから起こることすべて", "三秋縋", 1);
INSERT ticket (src_user_id, dst_user_id, title, description, status) VALUES (3, 3, "変わってしまった人、変われなかった人", "三秋縋", 1);
INSERT ticket (src_user_id, dst_user_id, title, description, status) VALUES (3, 3, "タイムカプセル荒らし", "三秋縋", 1);
INSERT ticket (src_user_id, dst_user_id, title, description, status) VALUES (3, 3, "不適切な行動", "三秋縋", 1);
INSERT ticket (src_user_id, dst_user_id, title, description, status) VALUES (3, 3, "できすぎた話", "三秋縋", 1);
INSERT ticket (src_user_id, dst_user_id, title, description, status) VALUES (3, 3, "私の、たった一人の幼馴染へ", "三秋縋", 1);

INSERT ticket (src_user_id, dst_user_id, title, description, status) VALUES (3, 3, "自販機巡りのすすめ", "三秋縋", 1);
INSERT ticket (src_user_id, dst_user_id, title, description, status) VALUES (3, 3, "嘘つきと小さな願い", "三秋縋", 1);
INSERT ticket (src_user_id, dst_user_id, title, description, status) VALUES (3, 3, "確かなこと", "三秋縋", 1);
INSERT ticket (src_user_id, dst_user_id, title, description, status) VALUES (3, 3, "青の時代", "三秋縋", 1);
INSERT ticket (src_user_id, dst_user_id, title, description, status) VALUES (3, 3, "賢者の贈り物", "三秋縋", 1);

INSERT ticket (src_user_id, dst_user_id, title, description, status) VALUES (3, 3, "追い剥ぎゴブリン", "遊戯王", 1);
INSERT ticket (src_user_id, dst_user_id, title, description, status) VALUES (3, 3, "アレキサンドライドラゴン", "遊戯王", 1);
INSERT ticket (src_user_id, dst_user_id, title, description, status) VALUES (3, 3, "ジェネティック・ワーウルフ", "遊戯王", 1);
INSERT ticket (src_user_id, dst_user_id, title, description, status) VALUES (3, 3, "ヴェルズ・ヘリオロープ", "遊戯王", 1);
INSERT ticket (src_user_id, dst_user_id, title, description, status) VALUES (3, 3, "デモンズ・チェーン", "遊戯王", 1);
INSERT ticket (src_user_id, dst_user_id, title, description, status) VALUES (3, 3, "レスキューラビット", "遊戯王", 1);
INSERT ticket (src_user_id, dst_user_id, title, description, status) VALUES (3, 3, "ジャイアント・オーク", "遊戯王", 1);
INSERT ticket (src_user_id, dst_user_id, title, description, status) VALUES (3, 3, "サイバー・ドラゴン", "遊戯王", 1);
INSERT ticket (src_user_id, dst_user_id, title, description, status) VALUES (3, 3, "墓守の番兵", "遊戯王", 1);
INSERT ticket (src_user_id, dst_user_id, title, description, status) VALUES (3, 3, "不意打ち又佐", "遊戯王", 1);

INSERT ticket (src_user_id, dst_user_id, title, description, status) VALUES (3, 3, "ビックバン・シュート", "遊戯王", 1);
INSERT ticket (src_user_id, dst_user_id, title, description, status) VALUES (3, 3, "流星の弓", "遊戯王", 1);
INSERT ticket (src_user_id, dst_user_id, title, description, status) VALUES (3, 3, "閃光の双剣", "遊戯王", 1);
INSERT ticket (src_user_id, dst_user_id, title, description, status) VALUES (3, 3, "アームズ・ホール", "遊戯王", 1);
INSERT ticket (src_user_id, dst_user_id, title, description, status) VALUES (3, 3, "名工 虎鉄", "遊戯王, 1");
INSERT ticket (src_user_id, dst_user_id, title, description, status) VALUES (3, 3, "魔のデッキ破壊ウイルス", "遊戯王", 1);
INSERT ticket (src_user_id, dst_user_id, title, description, status) VALUES (3, 3, "マジック・ドレイン", "遊戯王", 1);
INSERT ticket (src_user_id, dst_user_id, title, description, status) VALUES (3, 3, "砂塵の大竜巻", "遊戯王", 1);
INSERT ticket (src_user_id, dst_user_id, title, description, status) VALUES (3, 3, "最終突撃命令", "遊戯王", 1);
INSERT ticket (src_user_id, dst_user_id, title, description, status) VALUES (3, 3, "ゴゴゴジャイアント", "遊戯王", 1);

INSERT ticket (src_user_id, dst_user_id, title, description, status) VALUES (3, 3, "マジック・ドレイン", "遊戯王", 1);
INSERT ticket (src_user_id, dst_user_id, title, description, status) VALUES (3, 3, "カオス・インフィニティ", "遊戯王", 1);
INSERT ticket (src_user_id, dst_user_id, title, description, status) VALUES (3, 3, "禁じられた聖槍", "遊戯王", 1);
INSERT ticket (src_user_id, dst_user_id, title, description, status) VALUES (3, 3, "収縮", "遊戯王", 1);
INSERT ticket (src_user_id, dst_user_id, title, description, status) VALUES (3, 3, "鎖付きブーメラン", "遊戯王", 1);
INSERT ticket (src_user_id, dst_user_id, title, description, status) VALUES (3, 3, "奈落の落とし穴", "遊戯王", 1);
INSERT ticket (src_user_id, dst_user_id, title, description, status) VALUES (3, 3, "神の警告", "遊戯王", 1);
INSERT ticket (src_user_id, dst_user_id, title, description, status) VALUES (3, 3, "強制脱出装置", "遊戯王", 1);
INSERT ticket (src_user_id, dst_user_id, title, description, status) VALUES (3, 3, "激昂のミノタウルス", "遊戯王", 1);
INSERT ticket (src_user_id, dst_user_id, title, description, status) VALUES (3, 3, "平和の使者", "遊戯王", 1);
