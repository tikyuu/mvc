CREATE TABLE ticket(
id int not null auto_increment,
src_user int not null,
dst_user int not null,
title varchar(30),
description text not null,
primary key (id)
);
INSERT INTO ticket (src_user, dst_user, description) VALUES (1, 1, "test");
