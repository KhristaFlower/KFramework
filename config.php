<?php

/*
 * DATABASE CONFIGURATION
 */

define("DB_TYPE","mysql");
define("DB_HOST","localhost");
define("DB_USER","");
define("DB_PASS","");
define("DB_DATABASE","");

/*
 * PATH CONFIGURATION
 */

define("BASE_URL","");
define("PATH_CONTROLLERS","controllers/");
define("PATH_MODELS","models/");
define("PATH_VIEWS","views/");
define("PATH_ERROR_CONTROLLERS","controllers/errors/");

/*
 * SITE CONFIGURATION
 */

// SITE_ID should be unique for each installation of the framework on your domain.
define("SITE_ID","default");

// Find timezone strings at http://php.net/manual/en/timezones.php
define("TIMEZONE","Europe/London");
date_default_timezone_set(TIMEZONE);

// The name of the controller file to be used when one hasn't been selected.
define("SITE_DEFAULT_CONTROLLER","index");

// The default controller to use when throwing an unspecified error.
define("SITE_DEFAULT_ERROR_CONTROLLER","error");

?>
