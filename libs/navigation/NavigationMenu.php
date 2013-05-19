<?php

/**
 * NavigationMenu is used to store a list of categories and information about them.
 */
class NavigationMenu {

    /**
     * An array used for storing catagories and their sub-objects.
     * @var NavigationCategory Array of categories.
     */
    private $_categories;

    /**
     * Get the list of categories stored in this NavigationMenu.
     * @return array Array of NavigationCategory objects.
     */
    public function getCategoryArray(){
        return $this->_categories;
    }
    
    /**
     * Add a category to the navigation menu.
     * @param NavigationCategory A category to add to the menu.
     * @return NavigationMenu Return the object.
     */
    public function addCategory($category) {
        $this->_categories[] = $category;
        return $this;
    }
    
    /**
     * Get a NavigationCategory object from the menu by using its name.
     * @param String $categoryName Name of the category you wish to retrieve.
     * @return NavigationCategory Requested category.
     */
    public function getCategory($categoryName) {
        foreach ($this->_categories as $category) {
            if ($category->_name == $categoryName) {
                return $category;
            }
        }
        return null;
    }
    
    /**
     * Replace a category by name with the provided category.
     * @param String $categoryName Name of the category you wish to update.
     * @param NavigationCategory $newCategory New category to update with.
     * @return Boolean Did the update occour?
     */
    public function updateCategory($categoryName, $newCategory){
        $counter = 0;
        foreach($this->_categories as $category){
            if($category->_name == $categoryName){
                $this->_categories[$counter] = $newCategory;
                return true;
                break;
            }
            $counter++;
        }
        return false;
    }
    
    /**
     * Delete a category from the navigation by using its name.
     * @param String $categoryName Name of the category to delete.
     * @return Boolean Did we delete successfully?
     */
    public function deleteCategory($categoryName){
        $counter = 0;
        foreach($this->_categories as $category){
            if($category->_name == $categoryName){
                unset($this->_categories[$counter]);
                return true;
                break;
            }
            $counter++;
        }
        return false;
    }

}

?>
