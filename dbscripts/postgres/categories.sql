CREATE TABLE categories (
  id SERIAL,
  jamid INT NOT NULL,
  name TEXT NOT NULL,
  description TEXT NOT NULL,
  CONSTRAINT "categories_PK" PRIMARY KEY (id)
);
