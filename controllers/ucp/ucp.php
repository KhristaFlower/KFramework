<?php

class UCP extends UCP_Controller {

    function __construct() {
        parent::__construct();
        
        
    }
    
    public function navtest(){
        // Example of how to add a new item to an existing category.
        $homeCat = $this->view->_navMenu->getCategory("Home");
        $newNav = new NavigationItem("Test Link","/");
        $homeCat->addMenuItem($newNav);
        $this->view->_navMenu->updateCategory("Home",$homeCat);
        
        // Example of how to delete a menu item.
        $UCPCat = $this->view->_navMenu->getCategory("UCP");
        $UCPCat->deleteMenuItem("Profile");
        $this->view->_navMenu->updateCategory("UCP",$UCPCat);
        
        // Example of how to rename a menu item.
        $UCPGroupsOld = $this->view->_navMenu->getCategory("UCP");
        $newGroupsOption = $UCPGroupsOld->getMenuItem("Groups");
        $newGroupsOption->_name = "Groups UPDATED";
        $UCPGroupsOld->updateMenuItem("Groups",$newGroupsOption);
        $this->view->_navMenu->updateCategory("UCP",$UCPGroupsOld);
        
        $this->index();
    }

    public function index() {
        parent::index(__FILE__);
    }

}

?>
