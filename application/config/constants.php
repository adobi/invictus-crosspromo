<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');

define('SITE_TITLE', 'Invictus Admin');


if ($_SERVER['HTTP_HOST'] === 'localhost') {
    
  define('NEWS_URL', 'http://localhost/invictus-news/');
} else {
    
  define('NEWS_URL', 'http://invictus.com/invictus-news/');
}
define('NEWS_API_URL', NEWS_URL.'api/create');

if ($_SERVER['HTTP_HOST'] === 'localhost') {
    
  define('PRESS_RELEASE_URL', 'http://localhost/press/');
} else {
    
  define('PRESS_RELEASE_URL', 'http://press.invictus.com/');
}
define('PRESS_RELEASE_API_URL', PRESS_RELEASE_URL.'api/');
define('PRESS_RELEASE_CREATE_URL', PRESS_RELEASE_API_URL.'create');
define('PRESS_RELEASE_GET_TOKEN', PRESS_RELEASE_API_URL.'get_token_name');

if ($_SERVER['HTTP_HOST'] === 'localhost') {
    
  define('MICROSITES_URL', 'http://localhost/microsites/public/');
} else {
    
  define('MICROSITES_URL', 'http://invictus.com/microsites/');
}
define('MICROSITES_API_URL', MICROSITES_URL.'api/');
define('MICROSITES_CREATE_URL', MICROSITES_API_URL.'create/');



/* End of file constants.php */
/* Location: ./application/config/constants.php */