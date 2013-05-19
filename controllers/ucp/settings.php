<?php

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

?>
