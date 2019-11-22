DROP DATABASE IF EXISTS `mobly_teste`;

CREATE DATABASE `mobly_teste`
	CHARACTER SET utf8
    COLLATE utf8_general_ci;

USE `mobly_teste`;

CREATE TABLE `users` (
	`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(60) NOT NULL,
    `username` VARCHAR(20) NOT NULL,
    `email` VARCHAR(40) NOT NULL,
    `addr_street` VARCHAR(50) NOT NULL,
    `addr_suite` VARCHAR(15) NOT NULL,
    `addr_city` VARCHAR(25) NOT NULL,
    `addr_zipcode` VARCHAR(10) NOT NULL,
    `addr_geo_lat` VARCHAR(10) NOT NULL,
    `addr_geo_lng` VARCHAR(10) NOT NULL,
    `phone` VARCHAR(25) NOT NULL,
    `website` VARCHAR(30) NOT NULL,
    `co_name` VARCHAR(25) NOT NULL,
    `co_catchPhrase` VARCHAR(50) NOT NULL,
    `co_bs` VARCHAR(40) NOT NULL,
    CONSTRAINT `pk_users` PRIMARY KEY (`id`)
);

CREATE TABLE `posts` (
    `userId` INT UNSIGNED,
	`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `title` VARCHAR(255) NOT NULL,
    `body` TEXT NOT NULL, 
    CONSTRAINT `pk_post` PRIMARY KEY (`id`),
    CONSTRAINT `fk_user_userId` FOREIGN KEY (`userId`) REFERENCES `users` (`id`)
);