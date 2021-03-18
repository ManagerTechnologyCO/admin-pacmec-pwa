<?php
/* *******************************
 *
 * Developer by FelipheGomez
 *
 * ******************************/
/** Define PACMEC_PATH as this file's directory */
if (!defined('SITE_PATH')) define('SITE_PATH', dirname(PACMEC_PATH) . '/');
if (!defined('PACMEC_PATH')) define('PACMEC_PATH', __DIR__ . '/');
/**
*
* DISPLAY ERRORS ENABLED
*
**/
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// DATABASE CONFIG
define('DB_port', '3306');
define('DB_driver', 'mysql');
define('DB_host', 'localhost');
define('DB_user', 'root');
define('DB_pass', '');
define('DB_database', 'pacmec');
define('DB_charset', 'utf8mb4');
define('DB_prefix', 'mt_');

define('AUTH_KEY_COST', 10);
