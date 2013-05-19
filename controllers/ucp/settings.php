<?php

class Settings extends Controller {
    
    public function __construct($details)
    {
        parent::__construct($details);
        
        // Create a category to hold all themes we can switch to.
        $themeChangerCategory = new NavigationCategory("Theme Changer","/");
        
        // Select the themes directory.
        $directory = PATH_THEMES;
        // Get all files in that folder.
        $files = glob($directory . "*");
        foreach($files as $file){
            // Check to see if it is a folder.
            if(is_dir($file)){
                // Create a new link to set the active theme.
                $pathinfo = pathinfo($file);
                $file = $pathinfo['filename'];
                $themeChangerCategory->addMenuItem(new NavigationItem("$file","/ucp/settings/switchtheme/$file/"));
            }
        }
        $this->view->_navMenu->addCategory($themeChangerCategory);
    }
    
    public function switchtheme($args){
        // Apply the selected theme for 2 hours.
        $domainRaw = SITE_BASE_URL;
        $domainA = str_replace("http://", "", $domainRaw);
        $domain = str_replace("/", "", $domainA);
        echo "<br/>$domain<br/>";
        $time = time()+60*60*2;
        setcookie("KTheme", $args[0], $time, "/", $domain, false, true);
        $this->view->_params = $args;
        $this->renderPage("themechanged");
    }
    
    public function index(){
        parent::index();
    }
    
}

?>
