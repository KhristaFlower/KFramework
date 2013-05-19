<?php

set_include_path(__DIR__ . "/");

// Load the configuration
require_once 'config.php';

// Autoload the libraries
function __autoload($class) {
    $possibleDirs = array();
    $possibleDirs[] = "libs/";
    $possibleDirs[] = "libs/navigation/";
    $possibleDirs[] = "controllers/";
    
    foreach ($possibleDirs as $dir) {
        $file = "$dir$class.php";
        if(file_exists($file)){
            require_once $file;
            break;
        }else if(file_exists(strtolower($file))){
            // This check if performed because not every file name is the same case as the class we're looking for.
            require_once strtolower($file);
        }
    }
}

$KFramework = new KFramework();
$KFramework->init();

?>
