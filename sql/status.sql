create table status (
    id int not null auto_increment,
    name varchar(50) not null unique,
    primary key (id)
);

insert status (name) values ("新規");
insert status (name) values ("保留");
insert status (name) values ("終了");
