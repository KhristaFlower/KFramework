<?php

set_include_path(__DIR__ . "/");

// Load the configuration
require 'config.php';

// Autoload the libraries
function __autoload($class) {
    $possibleDirs = array();
    $possibleDirs[] = "libs/";
    $possibleDirs[] = "components/";

    foreach ($possibleDirs as $dir) {
        $file = "$dir$class.php";
        if(file_exists($file)){
            require $file;
        }
    }
}

$KFramework = new KFramework();
$KFramework->init();
?>