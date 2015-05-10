CREATE TABLE jams (
  id SERIAL,
  title TEXT NOT NULL,
  /* max themes suggested per user */
  themesperuser INT NOT NULL,
  /* flag if themes are auto approved for voting */
  autoapprovethemes BOOLEAN NOT NULL,
  /* how many voting rounds happen before final round */
  initialvotingrounds INT NOT NULL,
  /* max votes per user in each round */
  votesperuser INT NOT NULL,
  /* how many themes from each round advance to the final round */
  topthemesinfinal INT NOT NULL,
  suggestionsbegin BIGINT NOT NULL,
  suggestionslength BIGINT NOT NULL,
  approvallength BIGINT NOT NULL,
  votinglength BIGINT NOT NULL,
  themeannouncelength BIGINT NOT NULL,
  jamlength BIGINT NOT NULL,
  submissionslength BIGINT NOT NULL,
  judginglength BIGINT NOT NULL,
  status INT NOT NULL,
  /* the round that is currently being voted on
     always starts at the initialvotingrounds and
     ends at 0 for the final round */
  /* the round that is currently being voted on */
  currentround INT NOT NULL,
  /* the theme that has been selected for the jam */
  selectedthemeid INT NOT NULL,
  CONSTRAINT "jams_PK" PRIMARY KEY (id)
);
