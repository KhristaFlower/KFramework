<?php

/**
 * NavigationMenu is used to store a list of categories and information about them.
 */
class NavigationMenu {

    /**
     * An array used for storing catagories and their sub-objects.
     * @var NavigationSubMenu Array of categories.
     */
    private $_subMenus;

    /**
     * Get the list of submenus stored in this NavigationMenu.
     * @return array Array of NavigationSubMenu objects.
     */
    public function getSubMenus(){
        return $this->_subMenus;
    }
    
    /**
     * Add a submenu to the navigation menu.
     * @param NavigationSubMenu A submenu to add to the menu.
     * @return NavigationMenu Return the object.
     */
    public function addSubMenu($subMenu) {
        $this->_subMenus[] = $subMenu;
        return $this;
    }
    
    /**
     * Get a NavigationSubMenu object from the menu by using its name.
     * @param String $subMenuName Name of the submenu you wish to retrieve.
     * @return NavigationSubMenu Requested submenu.
     */
    public function getSubMenu($subMenuName) {
        foreach ($this->_subMenus as $subMenu) {
            if ($subMenu->_name == $subMenuName) {
                return $subMenu;
            }
        }
        return null;
    }
    
    /**
     * Replace a submenu by name with the provided submenu.
     * @param String $subMenuName Name of the submenu you wish to update.
     * @param NavigationSubMenu $newSubMenu New submenu to update with.
     * @return Boolean Did the update occour?
     */
    public function updateSubMenu($subMenuName, $newSubMenu){
        $counter = 0;
        foreach($this->_subMenus as $subMenu){
            if($subMenu->_name == $subMenuName){
                $this->_subMenus[$counter] = $newSubMenu;
                return true;
                break;
            }
            $counter++;
        }
        return false;
    }
    
    /**
     * Delete a submenu from the navigation by using its name.
     * @param String $subMenuName Name of the submenu to delete.
     * @return Boolean Did we delete successfully?
     */
    public function deleteSubMenu($subMenuName){
        $counter = 0;
        foreach($this->_subMenus as $subMenu){
            if($subMenu->_name == $subMenuName){
                unset($this->_subMenus[$counter]);
                return true;
                break;
            }
            $counter++;
        }
        return false;
    }
    
    /**
     * Create the output for this menu to be used in a HTML document.
     * 
     * @return String HTML containing the menu.
     */
    public function renderMenu(){
        $output = "<ul>";
        foreach ($this->getSubMenus() as $subMenu) {
            $output .= "<li>".$subMenu;
            
            $output .= "</li>";
        }
        $output .= "</ul>";
        return $output;
    }

}

?>
