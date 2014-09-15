CREATE  TABLE user_tokens (
  tokenid VARCHAR(64) NOT NULL,
  expires DATETIME NOT NULL,
  user_id INT NOT NUL,
  host TEXT NOT NULL,
  useragent TEXT NOT NULL);
