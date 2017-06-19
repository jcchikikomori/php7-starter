CREATE TABLE `user_types` (
  `id`	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
  `user_type`	VARCHAR DEFAULT 'user',
  `type_desc`	VARCHAR DEFAULT 'Default User'
);

INSERT INTO user_types (id, user_type, type_desc) VALUES (1, 'user', 'Common User');
INSERT INTO user_types (id, user_type, type_desc) VALUES (2, 'admin', 'Administrator');

CREATE TABLE `users` (
  `user_id`	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
  `user_name`	VARCHAR NOT NULL,
  `user_password`	VARCHAR NOT NULL,
  `user_email`	VARCHAR NOT NULL,
  `first_name`	VARCHAR NOT NULL,
  `middle_name`	VARCHAR NOT NULL,
  `last_name`	VARCHAR NOT NULL,
  `user_account_type`	TEXT,
  `created`	TEXT,
  `modified`	TEXT
);

-- RESET CODES
CREATE TABLE `reset_codes` (
  `id`	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
  `code`	VARCHAR NOT NULL,
  `email`	VARCHAR NOT NULL,
  `created` TEXT
);
