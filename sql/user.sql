
CREATE TABLE user(
id int NOT NULL AUTO_INCREMENT,
name varchar(30) NOT NULL UNIQUE,
password varchar(32) NOT NULL,
PRIMARY KEY (id)
);
