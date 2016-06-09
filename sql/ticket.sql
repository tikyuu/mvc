# CREATE TABLE ticket(
# id int not null auto_increment,
# label int default 0,
# status int default 0,
# src_user varchar(30) not null,
# dst_user varchar(30) not null,
# title varchar(30),
# description text not null,
# open_date timestamp default current_timestamp on update current_timestamp,
# close_date timestamp,
# primary key (id)
# );
# INSERT INTO ticket (src_user, dst_user, description) VALUES ("arakaki", "test", "test");
# INSERT INTO ticket (src_user, dst_user, description) VALUES ("arakaki", "test", "hoge");
