CREATE TABLE `user_types` (
  `id`	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
  `user_type`	TEXT DEFAULT 'user',
  `type_desc`	TEXT DEFAULT 'Default User'
);

INSERT INTO user_types (id, user_type, type_desc) VALUES (1, 'user', 'Common User');
INSERT INTO user_types (id, user_type, type_desc) VALUES (2, 'admin', 'Administrator');

CREATE TABLE `users` (
  `user_id`	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
  `user_name`	INTEGER NOT NULL,
  `user_password`	INTEGER NOT NULL,
  `user_email`	INTEGER NOT NULL,
  `first_name`	INTEGER NOT NULL,
  `middle_name`	INTEGER NOT NULL,
  `last_name`	INTEGER NOT NULL,
  `user_account_type`	INTEGER,
  `created`	TEXT,
  `modified`	TEXT
);