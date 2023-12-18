drop database tpsystem;

create database tpsystem;

use tpsystem;

create table `users`(
	`id_user` int unsigned not null auto_increment primary key,
	`name` varchar(100) not null,
	`password` varchar(255) not null,
	`date_create` datetime not null,
	`status` int
)ENGINE InnoDB DEFAULT CHARSET=UTF8MB4;

INSERT INTO `users` (`id_user`, `name`, `password`, `date_create`) VALUES (1, 'admin', '$2y$10$ZRFI8teXyoZ5wAvWPGcMbubpUcYJDdoKS7a1MUQVLjqmTL.ChjTJ2', '2023-01-27 18:36:17'),
	(2, 'other', '$2y$10$ZRFI8teXyoZ5wAvWPGcMbubpUcYJDdoKS7a1MUQVLjqmTL.ChjTJ2', '2023-01-27 18:36:17'),
	(3, 'damian', '$2y$10$UmfuOmTbXk/iUoAaP/Ij.uDW5SfU9yESq5gx1Up/p8Ax3HXMJB3Tq', '2023-01-27 18:36:17'),
	(4, 'gosia', '$2y$10$UmfuOmTbXk/iUoAaP/Ij.uDW5SfU9yESq5gx1Up/p8Ax3HXMJB3Tq', '2023-01-27 18:36:17'),
	(5, 'karolina', '$2y$10$UmfuOmTbXk/iUoAaP/Ij.uDW5SfU9yESq5gx1Up/p8Ax3HXMJB3Tq', '2023-01-27 18:36:17');
	
create table `user_history`(
	`id_history` int unsigned not null auto_increment primary key,
	`uid_user` int unsigned not null,
	`date_transaction` datetime not null,
	`type_transaction` int(3),
	`id_user` int unsigned not null
)ENGINE InnoDB DEFAULT CHARSET=UTF8MB4;

create table `access_list`(
	`access_table` int unsigned not null auto_increment primary key,
	`name` varchar(30) not null
)ENGINE InnoDB DEFAULT CHARSET=UTF8MB4;

INSERT INTO `access_list` (`access_table`, `name`) VALUES (1, 'setlist'),
		(2, 'newset'),
		(3, 'standchange'),
		(4, 'setedit'),
		(5, 'setremove'),
		(6, 'demand'),
        (7, 'QA'),
		(8, 'password'),
		(9, 'newuser'),
		(10, 'newmodel'),		
		(11, 'newstand'),
		(12, 'resetpassword'),
		(13, 'addaccess'),
	
create table `user_access`(
	`id_access` int unsigned not null auto_increment primary key,
	`uid_user` int unsigned not null,
	`setlist` int(1),
    `newset` int(1),
    `standchange` int(1),
    `setedit` int(1),
    `setremove` int(1),
    `demand` int(1),
    `QA` int(1),
    `password` int(1),
    `newuser` int(1),
    `newmodel` int(1),
    `newstand` int(1),
    `resetpassword` int(1),
    `addaccess` int(1)
)ENGINE InnoDB DEFAULT CHARSET=UTF8MB4;

INSERT INTO `user_access` (`id_access`, `uid_user`, `setlist`,  `newset`,`standchange`, `setedit`, `setremove`, `demand`, `QA`, `password`, `newuser`, `newmodel`, `newstand`, `resetpassword`, `addaccess`) VALUES 
    (1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1),
    (2, 2, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0),
    (3, 3, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0),
    (4, 4, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0),
    (5, 5, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0);
	
create table `access_history` (
	`id_hist` int unsigned not null auto_increment primary key,
	`uid_access` int unsigned not null,
	`gid_user` int unsigned not null,
	`uid_user` int unsigned not null,
	`date_create` datetime not null,
	`type_transaction` int
)ENGINE InnoDB DEFAULT CHARSET=UTF8MB4;
		
create table `stand`(
	`id_stand` int(3) unsigned not null auto_increment primary key,
	`name` varchar(40) not null,
	`status` int(1)
)ENGINE InnoDB DEFAULT CHARSET=UTF8MB4;

INSERT INTO `stand` (`id_stand`, `name`, `status`) VALUES (1, 'empty', 1),

create table `stand_history`(
	`id_history` int unsigned not null auto_increment primary key,
	`id_stand` int unsigned not null,
	`date_transaction` datetime not null,
	`type_transaction` int(3),
	`id_user` int unsigned not null
)ENGINE InnoDB DEFAULT CHARSET=UTF8MB4;

create table `setlist`(
	`id_set` int unsigned not null auto_increment primary key,
	`model` int unsigned not null,
	`description` varchar(100),
	`date_create` datetime not null,
	`id_user_make` int unsigned not null,
	`date_finish` datetime,
	`id_user_finish` int unsigned,
	`is_use` int(1) not null,
	`uid_stand` int(3) unsigned not null,
	`status` int(1)
)ENGINE InnoDB DEFAULT CHARSET=UTF8MB4;

INSERT INTO `setlist` (`id_set`, `model`, `description`, `date_create`, `id_user_make`, `date_finish`, `id_user_finish`, `is_use`, `uid_stand`, `status`) VALUES (1, 1, 'empty', '2023-01-27 18:36:17', 1, '2000-01-01 18:36:17', NULL, 0, 1, 1);

create table `set_use_history`(
	`id_use` int unsigned not null auto_increment primary key,
	`id_set` int unsigned not null,
	`date_transaction` datetime not null,
	`type_transaction` int(3),
	`uid_stand` int(3) not null,
	`uid_user` int unsigned not null
)ENGINE InnoDB DEFAULT CHARSET=UTF8MB4;

INSERT INTO `set_use_history` (`id_use`, `id_set`, `date_transaction`, `type_transaction`, `uid_stand`, `uid_user`) VALUES 
					(1, 1, '2023-01-13 20:07:55', 3, 2, 1),
					(2, 1, '2023-01-13 20:07:55', 3, 3, 1)

create table `type_transaction` (
	`id_transaction` int(3) not null auto_increment primary key,
	`name` varchar(100)
)ENGINE InnoDB DEFAULT CHARSET=UTF8MB4;

INSERT INTO `type_transaction` (`id_transaction`, `name`) VALUES (1, 'release set'),
    (2, 'return set'),
    (3, 'stand change'),
    (4, 'create set'),
    (5, 'add PN to set'),
    (6, 'change status SN'),
    (7, 'remove PN from set'),
    (8, 'remove set'),
    (9, 'close set, QA check'),
    (10, 'damaged'),
    (11, 'QA check'),
    (12, 'QA return good'),
    (13, 'QA return damaged'),
    (14, 'Add access'),
    (15, 'Remove access'),
    (16, 'active'),
    (17, 'deactivate'),
	(18, 'add new'),
	(19, 'change password'),
	(20, 'reset password'),
	(21, 'request PN to set'),
	(22, 'empty OH'),
	(23, 'close set, cancel request'),
	(24, 'receive WH'),
	(25, 'QA missing PN'),
	(26, 'WH missing PN'),
    (27, 'close, found'),
    (28, 'close, not found'),
    (29, 'return, not damaged');
	

create table `model`(
	`id_model` int unsigned not null auto_increment primary key,
	`uid_client` int(3) unsigned not null,
	`name` varchar(10) not null,
    `status` int
)ENGINE InnoDB DEFAULT CHARSET=UTF8MB4;

INSERT INTO `model` (`id_model`, `uid_client`, `name`, `status`) VALUES (1, 1, 'GDC50', 1),
					(2, 1, 'GDC70', 1),
					(3, 1, 'HDC40', 1);

create table `model_history`(
	`id_history` int unsigned not null auto_increment primary key,
	`id_model` int unsigned not null,
	`date_transaction` datetime not null,
	`type_transaction` int(3),
	`id_user` int unsigned not null
)ENGINE InnoDB DEFAULT CHARSET=UTF8MB4;
					
create table `client` (
	`id_client` int(3) unsigned not null auto_increment primary key,
	`name` varchar(10) not null,
	`stock` int not null
)ENGINE InnoDB DEFAULT CHARSET=UTF8MB4;	
	
INSERT INTO `client` (`id_client`, `name`, `stock`) VALUES 
					(1, 'A31', 3),
					(2, 'C38', 1);

create table `parts_set`(
    `id_parts` int unsigned not null auto_increment primary key,
    `id_set` int unsigned not null,
    `id_history_parts` int unsigned not null,
    `is_damaged` int(1),
    `status` int(1)
)ENGINE InnoDB DEFAULT CHARSET=UTF8MB4;

create table `parts_undercheck`(
	`id_req` int unsigned not null auto_increment primary key,
	`id_history_parts` int unsigned not null,
	`type_transaction` int(3),
	`date_create` datetime,
	`status` int(1)
)ENGINE InnoDB DEFAULT CHARSET=UTF8MB4;

create table `parts_history`(
    `id_history` int unsigned not null auto_increment primary key,
    `id_set` int unsigned not null,
    `id_pn` int unsigned not null,
    `sn` varchar(50) not null,
    `type_transaction` int(3),
    `date_create` datetime,
    `id_user` int
)ENGINE InnoDB DEFAULT CHARSET=UTF8MB4;
