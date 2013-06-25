<?php

/**
 * KFramework (http://kframework.csharman.co.uk/)
 * 
 * @link https://github.com/Kriptonic/KFramework The GitHub repository for this project.
 * @copyright (c) 2013, Christopher Sharman (http://csharman.co.uk)
 * @license http://www.apache.org/licenses/LICENSE-2.0 Licensed under the Apache License v2.0
 */
class NavigationElement {

    const TYPE_NORMAL = 0;
    const TYPE_DISABLED = 1;
    const TYPE_DIVIDER = 2;
    const TYPE_HEADING = 3;

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
    private $elementType = null;

    /**
     * An array used for storing children of this navigation element.
     * @var NavigationElement Array of navigation elements.
     */
    private $_elements;

    public function __construct($name = "", $link = "", $type = self::TYPE_NORMAL) {
        $this->_name = $name;
        $this->_link = $link;
        $this->elementType = $type;

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
    public function getName() {
        return $this->_name;
    }

    /**
     * Set the name of this element that should be displayed on the navigation.
     * @param string $name The name to be used on the element to identify it.
     * @return NavigationElement This element.
     */
    public function setName($name) {
        $this->_name = $name;
        return $this;
    }

    /**
     * Get the URL link for this element.
     * @return string The URL path to use as the element link.
     */
    public function getLink() {
        return $this->_link;
    }

    /**
     * Get the type of element that this object is being used as.
     * @return const NavigationElement constant.
     */
    public function getElementType() {
        return $this->elementType;
    }

    /**
     * Set the URL to use when this element is interacted with.
     * @param string $link The URL path from the base.
     * @return NavigationElement This element.
     */
    public function setLink($link) {
        $this->_link = $link;
        return $this;
    }

    /**
     * Check to see if this element has others inside of it.
     * @return boolean Does the element have sub-elements?
     */
    public function hasChildren() {
        return count($this->_elements) > 0;
    }

    public function render($floatdir = "pull-left") {
        $output = "<ul class='nav $floatdir'>";
        foreach ($this->getElements() as $element) {
            if ($element->hasChildren()) {
                // Render an item that has children
                $output .= "<li class='dropdown'>";
                $output .= "<a href='#' class='dropdown-toggle' data-toggle='dropdown'>{$element->getName()}<b class='caret'></b></a>";
                $output .= "<ul class='dropdown-menu'>";
                foreach ($element->getElements() as $element) {
                    $output = $element->renderDropdown($output);
                }
                $output .= "</ul>";
            } else {
                // Render a plain item that has no children.
                $output .= "<li>";
                $output .= "<a href='{$element->getLink()}'>{$element->getName()}</a>";
            }
            $output .= "</li>";
        }
        $output .= "</li>";
        $output .= "</ul>";
        return $output;
    }

    public function renderDropdown($output) {
        if ($this->elementType == self::TYPE_DIVIDER) {
            $output .= "<li class='divider'></li>";
        } else if ($this->elementType == self::TYPE_DISABLED) {
            $output .= "<li class='disabled'><a tabindex='-1' href='#' onclick='return false;'>{$this->getName()}</a></li>";
        } else if ($this->elementType == self::TYPE_HEADING) {
            $output .= "<li class='nav-header'>{$this->getName()}</li>";
        } else if ($this->elementType == self::TYPE_NORMAL) {
            if ($this->hasChildren()) {
                $output .= "<li class='dropdown-submenu'>";
                $output .= "<a href='{$this->getLink()}' class='dropdown-toggle' data-toggle='dropdown'>{$this->getName()}</a>";
                $output .= "<ul class='dropdown-menu'>";
                foreach ($this->getElements() as $element) {
                    $output = $element->renderDropdown($output);
                }
                $output .= "</ul>";
                $output .= "</li>";
            } else {
                $output .= "<li><a href='{$this->getLink()}'>{$this->getName()}</a></li>";
            }
        }
        return $output;
    }

}
