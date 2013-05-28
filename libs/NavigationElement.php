<?php

/**
 * NavigationElement is used to store information for menus as well as sub menus.
 */
class NavigationElement {
    
    /**
     * Name of this element to display on the menu. The base element does not use this.
     * @var String Name of this element.
     */
    private $_name;
    
    /**
     * The URL to the location you wish the element to send the user to. The base element does not use this.
     * @var string URL location to link to.
     */
    private $_link;
    
    /**
     * An array used for storing children of this navigation element.
     * @var NavigationElement Array of navigation elements.
     */
    private $_elements;

    public function __construct($name = "", $link = "") {
        $this->_name = $name;
        $this->_link = $link;
        
        return $this;
    }
    
    /**
     * Get the list of elements stored in this NavigationMenu.
     * @return array Array of NavigationElement objects.
     */
    public function getElements() {
        return $this->_elements;
    }

    /**
     * Add an element to the navigation element.
     * @param NavigationElement An element to add to the menu.
     * @return NavigationElement Return the object.
     */
    public function addElement($element) {
        $this->_elements[] = $element;
        return $this;
    }

    /**
     * Get a NavigationElement object from the menu by using its name.
     * @param String $elementName Name of the element you wish to retrieve.
     * @return NavigationElement Requested element.
     */
    public function getElement($elementName) {
        foreach ($this->_elements as $element) {
            if ($element->_name == $elementName) {
                return $element;
            }
        }
        return null;
    }

    /**
     * Replace an element by name with the provided element.
     * @param String $elementName Name of the element you wish to update.
     * @param NavigationElement $newElement New element to update with.
     * @return NavigationElement A copy of this.
     */
    public function updateElement($elementName, $newElement) {
        $counter = 0;
        foreach ($this->_elements as $element) {
            if ($element->_name == $elementName) {
                $this->_elements[$counter] = $newElement;
                return $this;
            }
            $counter++;
        }
        return null;
    }

    /**
     * Delete an element from the navigation by using its name.
     * @param String $elementName Name of the element to delete.
     * @return NavigationElement A copy of this.
     */
    public function deleteElement($elementName) {
        $counter = 0;
        foreach ($this->_elements as $element) {
            if ($element->_name == $elementName) {
                unset($this->_elements[$counter]);
                return $this;
            }
            $counter++;
        }
        return null;
    }
    
    /**
     * Get the name of the element.
     * @return string The name of this element.
     */
    public function getName(){
        return $this->_name;
    }
    
    /**
     * Set the name of this element that should be displayed on the navigation.
     * @param string $name The name to be used on the element to identify it.
     * @return NavigationElement This element.
     */
    public function setName($name){
        $this->_name = $name;
        return $this;
    }
    
    /**
     * Get the URL link for this element.
     * @return string The URL path to use as the element link.
     */
    public function getLink(){
        return $this->_link;
    }
    
    /**
     * Set the URL to use when this element is interacted with.
     * @param string $link The URL path from the base.
     * @return NavigationElement This element.
     */
    public function setLink($link){
        $this->_link = $link;
        return $this;
    }
    
    /**
     * Create the output for this menu to be used in a HTML document.
     * @return String HTML containing the menu.
     */
    public function renderMenu() {
        $output = "";
        if (count($this->getElements()) > 0) {
            $output .= "<ul class='mainNav'>";
            foreach ($this->getElements() as $element) {
                $output = $element->render($output);
            }
            $output .= "</ul>";
        }
        return $output;
    }
    
    /**
     * Create the HTML used to display the menu.
     * @param string $output Variable to append element data to.
     * @return string
     */
    private function render($output){
        $output .= "<li>";
        if(count($this->getElements()) > 0){
            $output .= "<a href='{$this->getLink()}' class='navMenuMore'>{$this->getName()}</a>";
            $output .= "<ul>";
            foreach($this->getElements() as $element){
                $output = $element->render($output);
            }
            $output .= "</ul>";
        }else{
            $output .= "<a href='{$this->getLink()}'>{$this->getName()}</a>";
        }
        $output .= "</li>";
        return $output;
    }

}

?>
