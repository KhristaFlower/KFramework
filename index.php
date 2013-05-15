<?

set_include_path(__DIR__."/");

// Load the configuration
require 'config.php';

// Autoload the libraries
function __autoload($class)
{
    require "libs/$class.php";
}

$KFramework = new KFramework();
$KFramework->init();

?>