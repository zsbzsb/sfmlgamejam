CREATE TABLE themes (
  id SERIAL,
  name TEXT NOT NULL,
  jamid INT NOT NULL,
  submitterid INT NOT NULL,
  canvote BOOLEAN NOT NULL,
  CONSTRAINT "themes_PK" PRIMARY KEY (id)
);
