CREATE TABLE images (
  id SERIAL,
  url TEXT NOT NULL,
  gameid INT NOT NULL,
  CONSTRAINT "images_PK" PRIMARY KEY (id)
);
