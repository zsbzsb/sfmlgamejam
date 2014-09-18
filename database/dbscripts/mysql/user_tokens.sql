CREATE  TABLE user_tokens (
  tokenid TEXT NOT NULL,
  expires BIGINT NOT NULL,
  user_id INT NOT NULL,
  host TEXT NOT NULL,
  useragent TEXT NOT NULL);
