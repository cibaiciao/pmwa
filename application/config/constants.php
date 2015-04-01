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

define("PROJECT","Project Management Web Application");
define("HASHKEY","Sdfsdf$#%435345DFAsdfadsf43253");
// API
define("APIKEY","CPSC597-II");


// RESTFUL STATUS CODE

define("UNAUTHORIZED",401);
define("FORBIDDEN",403);
define("CONFLICT",409);
define("INTERNAL_SERVER_ERROR",500);
define("BAD_REQUEST",400);
define("SUCCESS",200);
define("NO_CONTENT",204);

// task status



define("OPEN",0);
define("IN_PROGRESS",1);
define("QA",2);
define("CLOSED",3);


/* End of file constants.php */
/* Location: ./application/config/constants.php */