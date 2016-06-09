
CREATE TABLE user(
id int NOT NULL AUTO_INCREMENT,
name varchar(30) NOT NULL UNIQUE,
password varchar(30) NOT NULL,
PRIMARY KEY (id)
);
INSERT INTO user (name, password) VALUES ('arakaki', 'arakaki');
INSERT INTO user (name, password) VALUES ('test', 'test');
