CREATE TABLE jams (
  id SERIAL,
  title TEXT NOT NULL,
  suggestionsstart BIGINT NOT NULL,
  suggestionsend BIGINT NOT NULL,
  jamstart BIGINT NOT NULL );
