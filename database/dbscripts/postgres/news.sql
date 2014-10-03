CREATE TABLE news (
  id SERIAL,
  title TEXT NOT NULL,
  date BIGINT NOT NULL,
  summary TEXT NOT NULL,
  content TEXT NOT NULL,
  CONSTRAINT "news_PK" PRIMARY KEY (id)
);
