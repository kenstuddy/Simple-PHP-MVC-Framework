CREATE DATABASE people;

use people;

CREATE TABLE users (
	user_id INT NOT NULL AUTO_INCREMENT, 
	name VARCHAR(155) NOT NULL, 
	PRIMARY KEY(user_id)
);