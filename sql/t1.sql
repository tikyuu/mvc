
CREATE TABLE user(
user_id varchar(30) NOT NULL UNIQUE,
password varchar(30) NOT NULL
);
INSERT INTO user (user_id, password) VALUES ('arakaki', 'arakaki');