<?php

/**
 * NavigationSubMenu is used to contain a list of menu items, their links, and permissions.
 */
class NavigationSubMenu {

    /**
     * The name of the submenu that should be displayed on the menu.
     * @var string The name of the submenu on the navigation menu.
     */
    private $_name;

    /**
     * The link to send the user to when the submenu name is clicked.
     * @var string The link relative to the root where the submenu heading will take us.
     */
    private $_link;

    /**
     * Contains a list of NavigationItems for the current submenu.
     * @var array An array holding NavigationItem objects to display with this menu.
     */
    private $_menuItems;

    /**
     * Store whether the submenu should have interaction enabled.
     * @var boolean Is the submenu enabled?
     */
    private $_enabled = true;

    /**
     * Used to provide an indication that the page the user is on relates to this submenu.
     * @var boolean Should this submenu be hilighted on the navigation bar?
     */
    private $_active = false;

    /**
     * Create a new submenu with the specified name.
     * @param string $name Name of the navigation submenu.
     * @param string $link Path the navigation submenu should link to.
     * @param boolean $enabled Should the submenu respond to user interaction?
     * @param boolean $active Should the submenu show hilighted in the navigation?
     */
    public function __construct($name = "", $link = "", $enabled = true, $active = false) {
        $this->_name = $name;
        $this->_link = $link;
        $this->_enabled = $enabled;
        $this->_active = $active;
        
        return $this;
    }
    
    /**
     * 
     * @return array An array containing all NavigationItems items.
     */
    public function getMenuItems(){
        return $this->_menuItems;
    }

    /**
     * Add a component to the navigation menu.
     * @param NavigationItem $navigationItem Menu item to append to the submenu.
     */
    public function addMenuItem($navigationItem) {
        $this->_menuItems[] = $navigationItem;
        return $this;
    }
    
    /**
     * Get a NavigationItem from the submenu by using its name.
     * @param String $menuItemName The name of the navigation item you wish to retrieve.
     * @return NavigationItem The requested navigation item object.
     */
    public function getMenuItem($menuItemName){
        foreach($this->_menuItems as $menuItem){
            if($menuItem->_name == $menuItemName){
                return $menuItem;
            }
        }
        return null;
    }
    
    /**
     * Search for and replace a NavigationItem with another.
     * @param string $menuItemName The name of the navigation item you wish to search for.
     * @param NavigationItem $newMenuItem The navigation item you wish to use as a replacement.
     * @return boolean Did the update succeed?
     */
    public function updateMenuItem($menuItemName, $newMenuItem){
        $counter = 0;
        foreach($this->_menuItems as $menuItem){
            if($menuItem->_name == $menuItemName){
                $this->_menuItems[$counter] = $newMenuItem;
                return true;
                break;
            }
            $counter++;
        }
        return false;
    }
    
    /**
     * Search for and find a navigation item with the name provided and delete it.
     * @param string $menuItemName The name of the navigation item you wish to delete.
     * @return boolean Did the deletion occour?
     */
    public function deleteMenuItem($menuItemName){
        $counter = 0;
        foreach($this->_menuItems as $menuItem){
            if($menuItem->_name == $menuItemName){
                unset($this->_menuItems[$counter]);
                return true;
                break;
            }
            $counter++;
        }
        return false;
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
