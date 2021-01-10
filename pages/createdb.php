<?php
include_once ('classes.php');
$pdo=Tools::connect();


$role='create table roles(
id int not null auto_increment primary key,
role varchar (32) not null unique 
)default charset="utf8"';

$customer='create table customers(
id int not null auto_increment primary key,
login varchar (32) not null unique ,
pass varchar (128) not null ,
roleid int,
foreign key (roleid) references roles(id) on update cascade,
discount int,
total int,
imagepath varchar (255)
)default charset="utf8"';

$category='create table categories(
id int not null auto_increment primary key,
category varchar (64) not null unique 
)default charset="utf8"';

$subcategory='create table subategories(
id int not null auto_increment primary key,
subcategory varchar (64) not null unique,
catid int,
foreign key (catid) references categories(id) on update cascade 
)default charset="utf8"';

$item='create table items(
id int not null auto_increment primary key,
itemname varchar (128),
catid int,
foreign key (catid) references categories(id) on update cascade,
pricein int not null,
pricesale int not null,
info varchar (2048) not null,
rate double,
imagepath varchar(255) not null,
action int
)default charset="utf8"';

$images='create table images(
id int not null auto_increment primary key,
itemid int,
foreign key (itemid) references items(id) on delete cascade,
imagepath varchar (255)
)default charset="utf8"';

$sale='create table sales(
id int not null auto_increment primary key,
customername varchar (32),
itemname varchar (128),
pricein int,
pricesale int,
datasale date 
)default charset="utf8"';

//$pdo->exec($role);
//$pdo->exec($customer);
//$pdo->exec($category);
//$pdo->exec($subcategory);
//$pdo->exec($item);
//$pdo->exec($images);
//$pdo->exec($sale);

$ins="INSERT INTO roles(id,role) VALUES (null,'Admin'),(null,'Customer')";

$pdo->exec($ins);