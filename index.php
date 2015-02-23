<?php 

// global defines
define('ROOT', $_SERVER['DOCUMENT_ROOT'].'/');
define('SCRIPTROOT', ROOT.'/scripts/');
define('TEMPLATEROOT', ROOT.'/content/templates/');
define('PAGEROOT', ROOT.'/content/pages/');

// activate error reporting
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);

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
  // TODO return actual 404 page
  echo 'Oops, something went wrong [404] :(';
}
else
{
  // setup db access
  require ROOT.'database/dbaccess.php';

  $dbconnection = CreateDBConnection();

  // setup login session
  require ROOT.'session/loginsession.php';

  $session = new LoginSession();

  // get route target information
  $target = $route['target'];

  // make sure we meet authentication requirements
  $requiresauthentication = isset($target['usersonly']) && $target['usersonly'];
  $requiresadmin = isset($target['adminonly']) && $target['adminonly'];
  $requiresguest = isset($target['guestonly']) && $target['guestonly'];

  if ($requiresauthentication || $requiresadmin) RequireAuthentication($requiresadmin);
  else if ($requiresguest) RequireGuest();

  // extract any route parameters
  extract($route['params']);

  // now get the actual page
  $method = $_SERVER['REQUEST_METHOD'];

	if (!isset($target['controller']))
	{
		if ($method == 'GET')
		{
			// page header and body
		  require TEMPLATEROOT.'header.php';
		  require TEMPLATEROOT.'body.php';

			require PAGEROOT.$target['source'];

		  // page footer
		  require TEMPLATEROOT.'footer.php';
		}
	}
	elseif ($target['controller'] == 'script')	
	{
		if ($method == 'POST')
		{
			require SCRIPTROOT.$target['source'];
		}
	}
}

?>
