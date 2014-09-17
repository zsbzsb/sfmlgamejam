CREATE TABLE users (
  id INT NOT NULL AUTO_INCREMENT,
  username TEXT NOT NULL,
  password TEXT NOT NULL,
  salt TEXT NOT NULL,
  email TEXT NOT NULL,
  status INT NOT NULL,
  specialcode TEXT NOT NULL,
  avatar TEXT NOT NULL,
  about TEXT NOT NULL,
  website TEXT NOT NULL,
  PRIMARY KEY (id),
  UNIQUE INDEX id_UNIQUE (id ASC));
