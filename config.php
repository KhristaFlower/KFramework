<?php
$databaseConfigExport = 'config_db.php';
if(file_exists($databaseConfigExport)){
    require_once($databaseConfigExport);
}

/*
 * DATABASE CONFIGURATION
 */

if (isset($sql_array)) {
    // Array information saved via setup files.
    define("DB_TYPE", "mysql");
    define("DB_HOST", "localhost");
    define("DB_USER", "{$sql_array['user']}");
    define("DB_PASS", "{$sql_array['pass']}");
    define("DB_DATABASE", "{$sql_array['db']}");
}
unset($sql_array, $databaseConfigExport);

/*
 * PATH CONFIGURATION
 */

define("PATH_CONTROLLERS", "controllers/");
define("PATH_MODELS", "models/");
define("PATH_VIEWS", "views/");
define("PATH_ERROR_CONTROLLERS", "controllers/errors/");

define("PATH_THEMES", "public/css/themes/");
define("PATH_CSS", "public/css/");

/*
 * SITE CONFIGURATION
 */

// The URL to the directory containing this file.
// Manually set the SITE_BASE_URL if the $automaticAttempt fails.
$automaticAttempt = $_SERVER['HTTP_HOST'];
define("SITE_BASE_URL", "http://$automaticAttempt/");

// SITE_ID should be unique for each installation of the framework on your domain.
define("SITE_ID", "default");

// The name of the controller file to be used when one hasn't been selected.
define("SITE_DEFAULT_CONTROLLER", "index");

// The default controller to use when throwing an unspecified error.
define("SITE_DEFAULT_ERROR_CONTROLLER", "error");

// Find timezone strings at http://php.net/manual/en/timezones.php
define("TIMEZONE", "Europe/London");
date_default_timezone_set(TIMEZONE);

// The default website theme (this is the name of a subfolder in the themes folder)
define("SITE_DEFAULT_THEME", "default");

/*
 * HASHING CONFIGURATION
 */
define("HASHING_COST", 10);
define("HASHING_PORTABLE", false);
// Should be true if you have access to /dev/urandom
define("HASHING_USE_URANDOM", false);
// Should be true if targeting PHP 5.3.7 or later.
define("HASHING_2Y_OVER_2A", true);
