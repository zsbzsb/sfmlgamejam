CREATE TABLE games (
  id SERIAL,
  name TEXT NOT NULL,
  description TEXT NOT NULL,
  submitterid INT NOT NULL,
  partner TEXT NOT NULL,
  thumbnailurl TEXT NOT NULL,
  jamid INT NOT NULL,
  CONSTRAINT "games_PK" PRIMARY KEY (id)
);
