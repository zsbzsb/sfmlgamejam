<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/database/dbaccess.php';

function GetHost()
{
  return $_SERVER['REMOTE_ADDR'].(isset($_SERVER['HTTP_CLIENT_IP']) ? $_SERVER['HTTP_CLIENT_IP'] : "").(isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : "");
}

function GetUserAgent()
{
  return $_SERVER['HTTP_USER_AGENT'];
}

class LoginSession
{
  private $m_loggedin;
  private $m_userid;
  private $m_username;

  public function __construct()
  {
    global $COOKIE_TOKENID;
    global $dbconnection;
    $this->m_loggedin = false;
    $this->m_userid = -1;
    $this->m_username = 'Guest';
    date_default_timezone_set('America/New_York');
    if (isset($_COOKIE[$COOKIE_TOKENID]))
    {
      $stmt = $dbconnection->prepare("SELECT * FROM user_tokens WHERE tokenid = ?;");
      $stmt->execute(array($_COOKIE[$COOKIE_TOKENID]));
      $rows = $stmt->fetchAll();
      if ($rows->rowCount() == 0) return;
      if ($rows[0]['expires'] < date() && $rows[0]['host'] == GetHost() && $rows[0]['useragent'] == GetUserAgent())
      {
        $this->m_loggedin = true;
        $this->m_userid = $rows[0]['user_id'];
      }
    }
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
