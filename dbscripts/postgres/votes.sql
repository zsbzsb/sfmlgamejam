CREATE TABLE votes (
  id SERIAL,
  voterid INT NOT NULL,
  themeid INT NOT NULL,
  jamid INT NOT NULL,
  round INT NOT NULL,
  value INT NOT NULL,
  CONSTRAINT "votes_PK" PRIMARY KEY (id)
);
