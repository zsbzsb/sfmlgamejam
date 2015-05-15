CREATE TABLE links (
  id SERIAL,
  title TEXT NOT NULL,
  url TEXT NOT NULL,
  gameid INT NOT NULL,
  CONSTRAINT "links_PK" PRIMARY KEY (id)
);
