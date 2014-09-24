CREATE TABLE jams (
  id INT NOT NULL AUTO_INCREMENT,
  title TEXT NOT NULL,
  suggestionsstart BIGINT NOT NULL,
  suggestionsend BIGINT NOT NULL,
  jamstart BIGINT NOT NULL,
  PRIMARY KEY (id),
  UNIQUE INDEX id_UNIQUE (`id ASC));
