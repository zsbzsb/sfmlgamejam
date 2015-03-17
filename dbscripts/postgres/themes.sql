CREATE TABLE themes (
  id SERIAL,
  name TEXT NOT NULL,
  jamid INT NOT NULL,
  submitterid INT NOT NULL,
  /* set by an admin to determine if theme is eligable for voting */
  isapproved BOOLEAN NOT NULL,
  round INT NOT NULL,
  CONSTRAINT "themes_PK" PRIMARY KEY (id)
);
