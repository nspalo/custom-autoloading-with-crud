/*
 * Sample Database
 */
CREATE DATABASE IF NOT EXISTS `_db_sample`;
USE `_db_sample`;

/*
 * Database table
 */
CREATE TABLE IF NOT EXISTS `users`
(
  `id`        BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username`  VARCHAR(64) NOT NULL,
  `password`  VARCHAR(64) NOT NULL,
  `name`      VARCHAR(64) NOT NULL,
  `email`     VARCHAR(64) NOT NULL,
  PRIMARY KEY( `id` )
) ENGINE=INNODB DEFAULT CHARSET=utf8;

/*
 * Test Data
 * - password
 * -- method: SHA256
 * -- value: 1234
 */
INSERT INTO `users` ( `username`, `password`, `name`, `email` )
VALUES
("Admin", "03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4", "Admin User", "admin@test.com" ),
("TestUser1", "03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4", "Test User 1", "testuser1@test.com" )
;