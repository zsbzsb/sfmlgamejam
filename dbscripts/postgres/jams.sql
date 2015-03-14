CREATE TABLE jams (
  id SERIAL,
  title TEXT NOT NULL,
  themesperuser INT NOT NULL,
  autoenablethemes BOOLEAN NOT NULL,
  initialvotingrounds INT NOT NULL,
  roundvotes INT NOT NULL,
  votesperuser INT NOT NULL,
  suggestionsstart BIGINT NOT NULL,
  suggestionsend BIGINT NOT NULL,
  votingstart BIGINT NOT NULL,
  jamstart BIGINT NOT NULL,
  jamlenght BIGINT NOT NULL,
  submissionslength BIGINT NOT NULL,
  status INT NOT NULL,
  currentround INT NOT NULL,
  CONSTRAINT "jams_PK" PRIMARY KEY (id)
);
