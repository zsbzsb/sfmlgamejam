CREATE TABLE ratings (
  id SERIAL,
  categoryid INT NOT NULL,
  gameid INT NOT NULL,
  userid INT NOT NULL,
  value INT NOT NULL,
  CONSTRAINT "ratings_PK" PRIMARY KEY (id)
);
