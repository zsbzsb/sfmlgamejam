<?php

// global defines
define('ROOT', $_SERVER['DOCUMENT_ROOT'].'/');
define('SCRIPTROOT', ROOT.'/scripts/');
define('TEMPLATEROOT', ROOT.'/content/templates/');
define('PAGEROOT', ROOT.'/content/pages/');
define('APIROOT', ROOT.'/api/');

// grab the settings settings
require ROOT.'settings.php';

// set timezone
date_default_timezone_set('UTC');

// setup cache
require SCRIPTROOT.'phpfastcache/phpfastcache.php';

phpFastCache::setup('storage', 'auto');
$cache = phpFastCache();

// setup routing
require SCRIPTROOT.'AltoRouter/AltoRouter.php';

$routes = new AltoRouter();

// load the actual routes
require ROOT.'routes.php';

// handle the route request
$route = $routes->match();

if (!$route)
{
  // route wasn't found - return 404
  http_response_code(404);
  // TODO return actual 404 page
  echo 'Oops, something went wrong [404] :(';
  die();
}
else
{
  // get route target information
  $target = $route['target'];

  // all API requests will use a HTTP GET request method
  $apirequest = $_SERVER['REQUEST_METHOD'] == 'POST';

  // if it is an API request we will load all JSON variables from the request body into $_POST since php doesn't do this automatically
  if ($apirequest)
  {
    $_POST = json_decode(file_get_contents('php://input'), true);

    // also if the POST values contained the session id and it wasn't set in the headers we will set it here
    if (isset($_POST['token'])) $_COOKIE[$SESSION['tokenid']] = $_POST['token'];
  }

  // setup db access
  require SCRIPTROOT.'dbaccess.php';

  $dbconnection = CreateDBConnection();

  // setup login session
  require SCRIPTROOT.'loginsession.php';

  $session = new LoginSession();

  // make sure we meet authentication requirements
  $requiresauthentication = isset($target['usersonly']) && $target['usersonly'];
  $requiresadmin = isset($target['adminsonly']) && $target['adminsonly'];
  $requiresguest = isset($target['guestsonly']) && $target['guestsonly'];

  // check if we need to be authenticated
  if ($requiresauthentication || $requiresadmin)
  {
    if (!$session->IsLoggedIn() || ($requiresadmin && $session->GetStatus() != AccountStatus::Admin))
    {
      if ($apirequest)
      {
        http_response_code(401);
        // TODO return actual 401 page
        echo 'Oops, something went wrong [401] :(';
      }
      else header('Location: '.$routes->generate('login'));
      die();
    }
  }

  // check that we should *not* be logged in
  else if ($requiresguest)
  {
    if ($session->IsLoggedIn())
    {
      if ($apirequest)
      {
        http_response_code(401);
        // TODO return actual 401 page
        echo 'Oops, something went wrong [401] :(';
      }
      else header('Location: '.$routes->generate('account'));
      die();
    }
  }

  // handle an API request
  if ($apirequest)
  {
    if (isset($target['postvariables']))
    {
      foreach ($target['postvariables'] as $variable)
      {
        if (!isset($_POST[$variable]))
        {
          http_response_code(400);
          // TODO return actual 400 page
          echo 'Oops, something went wrong [400] :(';
          die();
        }
        else
        {
          $$variable = htmlspecialchars(trim($_POST[$variable]));
        }
      }
    }

    if (isset($target['optionalvariables']))
    {
      foreach ($target['optionalvariables'] as $variable)
      {
        if (isset($_GET[$variable]))
        {
          $$variable = htmlspecialchars(trim($_POST[$variable]));
        }
      }
    }

    require SCRIPTROOT.'apiresponse.php';
    require APIROOT.$target['source'];
  }

  // handle a normal page request
  else
  {
    // extract any route parameters
    extract($route['params']);

    // page header and body
    require TEMPLATEROOT.'header.php';
    require TEMPLATEROOT.'body.php';

    // page source
    require PAGEROOT.$target['source'];

    // page footer
    require TEMPLATEROOT.'footer.php';
  }
}

?>
