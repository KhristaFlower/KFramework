<?php

/**
 * KFramework (http://kframework.csharman.co.uk/)
 * 
 * @link https://github.com/Kriptonic/KFramework The GitHub repository for this project.
 * @copyright (c) 2013, Christopher Sharman (http://csharman.co.uk)
 * @license http://www.apache.org/licenses/LICENSE-2.0 Licensed under the Apache License v2.0
 * 
 * Based on information found at: http://blog.themeforest.net/tutorials/creating-an-html-friendly-template-system-using-phps-output-buffering/
 * Alterations have been made to allow for more than one level of template extending
 * as well as a way to nest upto one additional begin() and end() calls in each other.
 */
class Template {

    /**
     * Store the location of the template file relative to the KFramework root.
     * @var string Location of the template file.
     */
    protected $path = null;

    /**
     * Store the template that we are extending.
     * @var Template The template object that we are extending.
     */
    protected $extendedTemplate = null;

    /**
     * Store the HTML for the sections here, they override parent template content.
     * @var array Raw HTML output for specific sections of the template.
     */
    protected $sections = array();

    /**
     * The name of the current section (or the last one if a new one wasn't entered).
     * @var string Name of the current section.
     */
    protected $currentSection = null;
    protected $extendedSection = null;
    protected $extendedData = null;

    /**
     *
     * @var DataContainer An object to hold variable data.
     */
    protected $dataContainer = null;

    public function __construct($templateFile, $dataContainer = null) {
        $this->path = $templateFile;
        $this->dataContainer = $dataContainer;
    }

    /**
     * 
     * @return type
     */
    private function build() {
        // Start the buffer
        ob_start();

        // Include the template file specified in the constructor.
        include $this->path;

        // Get the contents of the loaded template and clear the buffer.
        $output = ob_get_clean();

        // Check to see if we have an extended template.
        if (!is_null($this->extendedTemplate)) {
            // Pass the sections of this template onto the extended template.
            $this->extendedTemplate->setSections($this->sections);
            $this->extendedTemplate->display();
        } else {
            // We are not extending a template, just return the found contents.
            echo $output;
        }
    }

    /**
     * Render all the HTML for the templates to the screen.
     */
    public function display() {
        $this->build();
    }

    /**
     * Assign a template that this one will extend.
     * @param string $name Path to the location of a template.
     */
    public function extend($name) {
        $this->extendedTemplate = new Template($name, $this->dataContainer);
    }

    /**
     * Triggered when entering a section of the template that we have loaded.
     * @param string $sectionName Name of the section in the template we are entering.
     */
    public function begin($sectionName) {
        if ($this->currentSection != null) {
            $this->extendedSection = $this->currentSection;
            $this->extendedData = ob_get_contents();
            ob_end_clean();
        }
        // Start the buffer.
        ob_start();
        $this->currentSection = $sectionName;
    }

    /**
     * Triggered when leaving a section of the template we have loaded.
     */
    public function end() {
        if ($this->extendedSection != null) {
            // Save the data found if we're not overwriting anything.
            if ($this->sections[$this->currentSection] == null) {
                $this->sections[$this->currentSection] = ob_get_clean();
            }
            ob_end_clean();
            ob_start();

            echo $this->extendedData;
            echo $this->sections[$this->currentSection];

            $this->currentSection = $this->extendedSection;
            $this->extendedSection = null;

            // At this point we don't do anything else except return to the main
            // section and resume parsing.
        } else {
            // Check to see if we are extending the structure of another template.
            if (!is_null($this->extendedTemplate)) {
                // We have an extended template.
                // Only store the section content if we don't already have some.
                if (!isset($this->sections[$this->currentSection])) {
                    // Store the current sections contents into an array to override parent.
                    $this->sections[$this->currentSection] = ob_get_clean();
                }
            } else {
                // The current template is the topmost template.
                // Check to see if a child template of this one has already set a
                // section for the one we are leaving.
                if (isset($this->sections[$this->currentSection])) {
                    // A child template has already rendered content for this
                    // section, clear the section data for the parent template
                    // and turn off the buffer.
                    ob_end_clean();

                    // Display the content created by the child template.
                    echo $this->sections[$this->currentSection];
                } else {
                    // A child template has not set content for this section.
                    // Print the master template content for this section.
                    echo ob_get_clean();
                }
            }
            $this->currentSection = null;
        }
    }

    /**
     * Set this templates section information to that of the child template.
     * @param array $sections Section HTML output from a child template.
     */
    public function setSections($sections) {
        $this->sections = $sections;
    }

    /**
     * 
     * @return DataContainer
     */
    public function getData() {
        return $this->dataContainer;
    }

    public function data() {
        return $this->dataContainer;
    }

    /**
     * Get controller data.
     */
    public function gcd() {
        return $this->dataContainer->getControllerData();
    }

}
