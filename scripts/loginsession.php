<?php

include_once $_SERVER['DOCUMENT_ROOT'].'/database/dbaccess.php';

abstract class AccountStatus
{
  const Banned = -1;
  const WaitingActivation = 0;
  const Normal = 1;
  const Admin = 2;
}

class LoginSession
{
  private $m_loggedin;
  private $m_userid;
  private $m_username;
  private $m_status;


  private function GetHost()
  {
    return $_SERVER['REMOTE_ADDR'].(isset($_SERVER['HTTP_CLIENT_IP']) ? $_SERVER['HTTP_CLIENT_IP'] : "").(isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : "");
  }

  private function GetUserAgent()
  {
    return $_SERVER['HTTP_USER_AGENT'];
  }

  public function __construct()
  {
    global $COOKIE_TOKENID;
    global $dbconnection;

    $this->m_loggedin = false;
    $this->m_userid = -1;
    $this->m_username = 'Guest';
    $this->m_status = AccountStatus::Banned;
    if (isset($_COOKIE[$COOKIE_TOKENID]))
    {
      $stmt = $dbconnection->prepare("SELECT * FROM user_tokens WHERE tokenid = ?;");
      $stmt->execute(array($_COOKIE[$COOKIE_TOKENID]));
      $rows = $stmt->fetchAll();
      if ($stmt->rowCount() == 0) return;
      if ($rows[0]['expires'] > time() && $rows[0]['host'] == $this->GetHost() && $rows[0]['useragent'] == $this->GetUserAgent())
      {
        $this->Login($rows[0]['user_id'], false);
      }
    }
  }

  public function TryRegister($Username, $Password, $Email)
  {
    global $dbconnection;

    if ($this->IsLoggedIn()) return false;
    $stmt = $dbconnection->prepare("SELECT COUNT(*) FROM users WHERE username = ? OR email = ?;");
    $stmt->execute(array($Username, $Email));
    $rows = $stmt->fetchAll();
    if ($stmt->rowCount() == 0) return false;
    if ($rows[0]['COUNT(*)'] > 0) return false;
    $stmt = $dbconnection->prepare("INSERT INTO users (username, password, salt, email, status, specialcode, avatar, about, website) VALUES (?, ?, ?, ?, ?, ?, '', '', '');");
    $salt = uniqid('', true);
    $stmt->execute(array($Username, hash("SHA512", $salt.$Password), $salt, $Email, AccountStatus::Normal, ''));
    $this->Login($dbconnection->lastInsertId(), true);
    return true;
  }

  public function TryLogin($Username, $Password)
  {
  }

  private function Login($UserID, $CreateToken)
  {
    global $COOKIE_TOKENID;
    global $SESSION_TIMEOUT;
    global $dbconnection;

    if ($CreateToken)
    {
      $stmt = $dbconnection->prepare("INSERT INTO user_tokens (tokenid, expires, user_id, host, useragent) VALUES (?, ?, ?, ?, ?);");
      $host = $this->GetHost();
      $useragent = $this->GetUserAgent();
      $tokenid = hash("SHA256", $host.$useragent.time().$UserID.uniqid('', true));
      $stmt->execute(array($tokenid, time() + $SESSION_TIMEOUT, $UserID, $host, $useragent));
      setcookie($COOKIE_TOKENID, $tokenid, time() + $SESSION_TIMEOUT, '/');
    }

    $stmt = $dbconnection->prepare("SELECT username, status FROM users WHERE id = ?;");
    $stmt->execute(array($UserID));
    $rows = $stmt->fetchAll();

    $this->m_loggedin = true;
    $this->m_userid = $UserID;
    $this->m_username = $rows[0]['username'];
    $this->m_status = $rows[0]['status'];
  }

  public function Logout()
  {
    global $COOKIE_TOKENID;
    global $dbconnection;

    if ($this->IsLoggedIn())
    {
      $stmt = $dbconnection->prepare("DELETE FROM user_tokens WHERE tokenid = ?;");
      $stmt->execute(array($_COOKIE[$COOKIE_TOKENID]));
    }
    setcookie($COOKIE_TOKENID, null, -1, '/');
  }

  public function IsLoggedIn()
  {
    return $this->m_loggedin;
  }

  public function GetUsername()
  {
    return $this->m_username;
  }
}

$session = new LoginSession();

?>
