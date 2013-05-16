<?php

/**
 * NavigationCategory is used to contain a list of menu items, their links, and permissions.
 */
class NavigationCategory {

    /**
     * The name of the category that should be displayed on the menu.
     * @var string The name of the category on the navigation menu.
     */
    public $_name;

    /**
     * The link to send the user to when the category name is clicked.
     * @var string The link relative to the root where the category heading will take us.
     */
    public $_link;

    /**
     * Contains a list of NavigationItems for the current category.
     * @var array An array holding NavigationItem objects to display with this menu.
     */
    public $_menuItems;

    /**
     * Store whether the category should have interaction enabled.
     * @var boolean Is the category enabled?
     */
    public $_enabled = true;

    /**
     * Used to provide an indication that the page the user is on relates to this category.
     * @var boolean Should this category be hilighted on the navigation bar?
     */
    public $_active = false;

    /**
     * Create a new category with the specified name.
     * @param string $name Name of the navigation category.
     * @param string $link Path the navigation category should link to.
     * @param boolean $enabled Should the category respond to user interaction?
     * @param boolean $active Should the category show hilighted in the navigation?
     */
    public function __construct($name = "", $link = "", $enabled = true, $active = false) {
        $this->_name = $name;
        $this->_link = $link;
        $this->_enabled = $enabled;
        $this->_active = $active;
        
        return $this;
    }

    /**
     * Add a component to the navigation menu.
     * @param NavigationItem $navigationItem Menu item to append to the category.
     */
    public function addMenuItem($navigationItem) {
        $this->_menuItems[] = $navigationItem;
        return $this;
    }
    
    /**
     * Get a NavigationItem from the category by using its name.
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

    /**
     * Enable or disable the category.
     * @param Boolean New value.
     */
    public function setEnabled($enabled) {
        $this->_enabled = $enabled;
    }

}

?>
