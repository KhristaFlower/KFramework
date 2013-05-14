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

/*
 * SITE CONFIGURATION
 */
// SITE_ID should be unique for each installation of the framework on your domain.
define("SITE_ID","default");
// Find timezone strings at http://php.net/manual/en/timezones.php
define("TIMEZONE","Europe/London");
date_default_timezone_set(TIMEZONE);

?>
