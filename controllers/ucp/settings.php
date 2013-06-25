<?php

/**
 * KFramework (http://kframework.csharman.co.uk/)
 * 
 * @link https://github.com/Kriptonic/KFramework The GitHub repository for this project.
 * @copyright (c) 2013, Christopher Sharman (http://csharman.co.uk)
 * @license http://www.apache.org/licenses/LICENSE-2.0 Licensed under the Apache License v2.0
 */
class Settings extends UCP {
    
    public function __construct($details)
    {
        parent::__construct($details);
    }
    
    public function switchtheme($args){
        // Apply the selected theme for 2 hours.
        $domainRaw = SITE_BASE_URL;
        $domainA = str_replace("http://", "", $domainRaw);
        $domain = str_replace("/", "", $domainA);
        $time = time()+60*60*2;
        setcookie("KTheme", $args[0], $time, "/", $domain, false, true);
        
        // Take the user back to the settings so we can see our changes instantly.
        header('Location: /ucp/settings/');
    }
    
    public function index(){
        parent::index();
    }
    
}
