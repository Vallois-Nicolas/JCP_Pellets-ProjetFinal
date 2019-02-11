#------------------------------------------------------------
#        Script MySQL.
#------------------------------------------------------------

#------------------------------------------------------------
# Database: jcp
#------------------------------------------------------------

CREATE DATABASE `jcp` CHARACTER SET 'utf8';
USE `jcp`;


#------------------------------------------------------------
# Table: jcp_users
#------------------------------------------------------------

CREATE TABLE `jcp_users`(
        `id`        Int  Auto_increment  NOT NULL ,
        `lastname`  Varchar (50) NOT NULL ,
        `firstname` Varchar (50) NOT NULL ,
        `birthdate` Date NOT NULL ,
        `phone`     Varchar (15) NOT NULL ,
        `mail`      Varchar (100) NOT NULL ,
        `username`  Varchar (50) NOT NULL ,
        `password`  Varchar (50) NOT NULL ,
	CONSTRAINT jcp_users_PK PRIMARY KEY (id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: jcp_users_delivery_infos
#------------------------------------------------------------

CREATE TABLE `jcp_users_delivery_infos`(
        `id`              Int  Auto_increment  NOT NULL ,
        `city`            Varchar (75) NOT NULL ,
        `streetAndNumber` Varchar (50) NOT NULL ,
        `postalCode`      Int NOT NULL ,
        `id_jcp_users`    Int NOT NULL ,
	CONSTRAINT `jcp_users_delivery_infos_PK` PRIMARY KEY (id) ,

	CONSTRAINT `jcp_users_delivery_infos_jcp_users_FK` FOREIGN KEY (id_jcp_users) REFERENCES `jcp_users`(id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: jcp_products
#------------------------------------------------------------

CREATE TABLE `jcp_products`(
        `id`    Int  Auto_increment  NOT NULL ,
        `price` Float NOT NULL ,
        `name`  Varchar (30) NOT NULL ,
        `image` Blob NOT NULL ,
	CONSTRAINT `jcp_products_PK` PRIMARY KEY (id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: jcp_orders
#------------------------------------------------------------

CREATE TABLE `jcp_orders`(
        `id`                          Int  Auto_increment  NOT NULL ,
        `id_jcp_users`                Int NOT NULL ,
        `id_jcp_users_delivery_infos` Int NOT NULL ,
        `id_jcp_products`             Int NOT NULL ,
	CONSTRAINT `jcp_orders_PK` PRIMARY KEY (id) ,

	CONSTRAINT `jcp_orders_jcp_users_FK` FOREIGN KEY (id_jcp_users) REFERENCES `jcp_users`(id) ,
	CONSTRAINT `jcp_orders_jcp_users_delivery_infos0_FK` FOREIGN KEY (id_jcp_users_delivery_infos) REFERENCES `jcp_users_delivery_infos`(id) ,
	CONSTRAINT `jcp_orders_jcp_products1_FK` FOREIGN KEY (id_jcp_products) REFERENCES `jcp_products`(id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: jcp_cart
#------------------------------------------------------------

CREATE TABLE `jcp_cart`(
        `id`              Int  Auto_increment  NOT NULL ,
        `id_jcp_products` Int NOT NULL ,
        `id_jcp_users`    Int NOT NULL ,
	CONSTRAINT `jcp_cart_PK` PRIMARY KEY (id) ,

	CONSTRAINT `jcp_cart_jcp_products_FK` FOREIGN KEY (id_jcp_products) REFERENCES `jcp_products`(id) ,
	CONSTRAINT `jcp_cart_jcp_users0_FK` FOREIGN KEY (id_jcp_users) REFERENCES `jcp_users`(id) ,
	CONSTRAINT `jcp_cart_jcp_users_AK` UNIQUE (id_jcp_users)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: jcp_user_types
#------------------------------------------------------------

CREATE TABLE `jcp_user_types`(
        `id`           Int  Auto_increment  NOT NULL ,
        `rights`       Varchar (50) NOT NULL ,
        `id_jcp_users` Int NOT NULL ,
	CONSTRAINT `jcp_user_types_PK` PRIMARY KEY (id) ,

	CONSTRAINT `jcp_user_types_jcp_users_FK` FOREIGN KEY (id_jcp_users) REFERENCES `jcp_users`(id)
)ENGINE=InnoDB;

