CREATE TABLE users (
id int not null primary key auto_increment,
username varchar(255),
password varchar(255),
active int
);

INSERT INTO users (username,password,active) VALUES ('steve','boo',1);
INSERT INTO users (username,password,active) VALUES ('bob','nightmare',1);
INSERT INTO users (username,password,active) VALUES ('ernie','rattler',1);
