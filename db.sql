create database forum;

use forum;

create table if not exists users(
	user_id int not null auto_increment primary key,
	permission int not null, /*prava za dostap (user, admin, moderator, ...)*/
	username varchar(255) not null,
	password varchar(255) not null,
	mail varchar(255) not null
);

create table if not exists categories(
	cat_id int not null auto_increment primary key,
	name varchar(255) not null
);

create table if not exists posts(
	post_id int not null auto_increment primary key,
	name varchar(255) not null COLLATE utf8_unicode_ci,
	content text not null COLLATE utf8_unicode_ci,
	user_id int not null, /*ot koi user e dobavena*/
	cat_id int not null, /*kam koq kategoriq e saotvetniqt podting (vapros)*/
	timeadded int not null,
	timeedited int not null,
	editfromwho int not null,
	visits int not null,
	foreign key (user_id) references users(user_id),
	foreign key (cat_id) references categories(cat_id)
);

create table if not exists tags(
	tag_id int not null auto_increment primary key,
	post_id int not null,
	tagname varchar (255) not null,
	foreign key (post_id) references posts(post_id)
);