CREATE TABLE users (
  id INT NOT NULL AUTO_INCREMENT,
  username TEXT NOT NULL,
  password TEXT NOT NULL,
  email TEXT NOT NULL,
  activated BIT NOT NULL,
  activationcode TEXT NOT NULL,
  avatar TEXT NOT NULL,
  about TEXT NOT NULL,
  website TEXT NOT NULL,
  PRIMARY KEY (id),
  UNIQUE INDEX id_UNIQUE (id ASC));
