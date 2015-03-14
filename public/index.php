<?php

// global defines
define('ROOT', realpath('..').'/');
define('SCRIPTROOT', ROOT.'scripts/');
define('TEMPLATEROOT', ROOT.'content/templates/');
define('VIEWROOT', ROOT.'content/views/');
define('MODALROOT', ROOT.'content/modals/');
define('APIROOT', ROOT.'api/');
define('EXT', '.php');

// grab the settings
require ROOT.'settings.php';

// grab status definitions
require SCRIPTROOT.'statusdefs.php';

// set timezone
date_default_timezone_set('UTC');

// setup cache
require SCRIPTROOT.'phpfastcache/phpfastcache.php';

phpFastCache::setup('storage', 'files');
phpFastCache::setup('path', ROOT.'cache');

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
  http_response_code(404);
  $error = 404;
  require PAGEROOT.'error.php';
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
    if (!$session->IsLoggedIn() || ($requiresadmin && ($session->GetStatus() != AccountStatus::Admin && $session->GetStatus() != AccountStatus::Owner)))
    {
      if ($apirequest)
      {
        http_response_code(401);
        $error = 401;
        require PAGEROOT.'error.php';
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
        $error = 401;
        require PAGEROOT.'error.php';
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
          $error = 400;
          require PAGEROOT.'error.php';
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
    require APIROOT.$target['source'].EXT;
  }

  // handle a normal page request
  else
  {
    // extract any route parameters
    extract($route['params']);

    // page header and body
    require TEMPLATEROOT.'header.php';
    require TEMPLATEROOT.'body.php';

    // page modal
    if (file_exists(MODALROOT.$target['source'].EXT)) require MODALROOT.$target['source'].EXT;

    // page view
    require VIEWROOT.$target['source'].EXT;

    // page footer
    require TEMPLATEROOT.'footer.php';
  }
}

?>
