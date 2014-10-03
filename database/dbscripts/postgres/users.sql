CREATE TABLE users (
  id SERIAL,
  username TEXT NOT NULL,
  password TEXT NOT NULL,
  salt TEXT NOT NULL,
  email TEXT NOT NULL,
  status INT NOT NULL,
  specialcode TEXT NOT NULL,
  avatar TEXT NOT NULL,
  about TEXT NOT NULL,
  website TEXT NOT NULL,
  CONSTRAINT "users_PK" PRIMARY KEY (id)
);
