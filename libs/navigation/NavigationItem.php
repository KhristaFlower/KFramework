<?php

/**
 * Class used to hold information about a navigation item.
 */
class NavigationItem {

    /**
     * Name of the link in the menu.
     * @var String Name of the link.
     */
    private $_name;

    /**
     * Path to a page relative to the root.
     * @var String URL from the root.
     */
    private $_link;

    /**
     * Stores the whether the user has an active session or not.
     * @var Boolean Is the user logged in?
     */
    private $_loginReq = false;

    /**
     * Stores whether the currently logged in account needs to be an admin to access the link.
     * @var Boolean Does the user need to be an admin?
     */
    private $_adminReq = false;

    /**
     * Stores whether the link should be active for clicking.
     * @var Boolean Should the link be enabled?
     */
    private $_enabled = true;

    /**
     * Used to hilight an item in the menu; this is usually the current page.
     * @var Boolean Is this item the active item?
     */
    private $_active = false;
    
    /**
     * Create a new navigation item for a navigtion category.
     * @param String $name Name of the navigation item.
     * @param String $path Path the navigation item should link to.
     * @param Boolean $loginReq Should the item require a logged in account to access?
     * @param Boolean $adminReq Should the item require admin rights to access?
     * @param Boolean $enabled Should the link respond to user interaction?
     * @param Boolean $active Should the item hilight in the navigation?
     * @return NavigationItem Returns self to enable calling multiple methods after one another.
     */
    public function __construct($name = "", $link = "", $loginReq = false, $adminReq = false, $enabled = true, $active = false){
        $this->_name = $name;
        $this->_link = $link;
        $this->_loginReq = $loginReq;
        $this->_adminReq = $adminReq;
        $this->_enabled = $enabled;
        $this->_active = $active;
        
        return $this;
    }
    
    public function __get($property){
        if(property_exists($this, $property)){
            return $this->$property;
        }
    }
    
    public function __set($property, $value){
        if(property_exists($this, $property)){
            $this->$property = $value;
        }
        return $this;
    }
    
}

?>
