CREATE TABLE votes (
  id SERIAL,
  themeid INT NOT NULL,
  voterid INT NOT NULL,
  round INT NOT NULL,
  value INT NOT NULL,
  CONSTRAINT "votes_PK" PRIMARY KEY (id)
);
