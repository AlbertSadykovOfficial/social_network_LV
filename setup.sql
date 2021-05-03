CREATE TABLE IF NOT EXISTS members(
					user VARCHAR(16),
					pass VARCHAR(16),
					INDEX(user(6))
				);

CREATE TABLE IF NOT EXISTS messages(
					id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
					auth VARCHAR(16),
					recip VARCHAR(16),
					pm CHAR(1),
					time INT UNSIGNED,
					message VARCHAR(4096),
					INDEX(auth(6)),
					INDEX(recip(6))
				);

CREATE TABLE IF NOT EXISTS friends(
					user VARCHAR(16),
					friend VARCHAR(16),
					INDEX(user(6)),
					INDEX(friend(6))
				);

CREATE TABLE IF NOT EXISTS profiles(
					user VARCHAR(16),
					text VARCHAR(4096),
					INDEX(user(6))
				);


INSERT INTO members VALUES('admin_user','admin_password');

