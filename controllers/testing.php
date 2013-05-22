<?php

class testing extends Controller {
    
    public function __construct($details){
        parent::__construct($details);
    }
    
    public function changenav(){
        // Get a copy of the menu.
        $nav = $this->_view->_navMenu;
        
        // Short way to update a menu element.
        $nav->getElement("UCP")->updateElement("Settings",new NavigationElement("SeTtInGs","/ucp/settings/"));
        // A few more examples of short updates.
        $nav->getElement("Tab 1")->updateElement("Item 1/1",new NavigationElement("Dog", "/ucp/testing/"));
        $nav->getElement("Tab 1")->updateElement("Item 1/2",new NavigationElement("Cat", "/ucp/testing/"));
        $nav->getElement("Tab 1")->updateElement("Item 1/3",new NavigationElement("Rat", "/ucp/testing/"));
        $nav->getElement("Tab 1")->updateElement("Item 1/4",new NavigationElement("Ant", "/ucp/testing/"));
        // Long way to update a menu element.
        $tab2 = $nav->getElement("Tab 2");
        $item1replacement = new NavigationElement("My Replacement Element","/ucp/testing/");
        $newTab = $tab2->updateElement("Item 2/1", $item1replacement);
        $nav->updateElement("Tab 2", $newTab);
        
        // Apply the changes.
        $this->_view->_navMenu = $nav;
        
        $this->index();
    }
    
    public function index(){
        parent::index();
    }
    
}

?>
