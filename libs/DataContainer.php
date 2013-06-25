<?php

/**
 * KFramework (http://kframework.csharman.co.uk/)
 * 
 * @link https://github.com/Kriptonic/KFramework The GitHub repository for this project.
 * @copyright (c) 2013, Christopher Sharman (http://csharman.co.uk)
 * @license http://www.apache.org/licenses/LICENSE-2.0 Licensed under the Apache License v2.0
 */
class DataContainer {

    protected $containerName;
    protected $subcontainers = array();
    protected $variableData = array();

    public function __construct($containerName) {
        $this->containerName = $containerName;
    }

    /**
     * 
     * @param DataContainer $container
     * @return DataContainer
     */
    public function addContainer($container) {
        if ($this->getContainer($container->getName()) == null) {
            $this->subcontainers[] = $container;
        }
        return $this;
    }

    /**
     * 
     * @param string $containerName Name of the container to return.
     * @return DataContainer The datacontainer found, else return null.
     */
    public function getContainer($containerName) {
        foreach ($this->subcontainers as $container) {
            if ($container->getName() == $containerName) {
                return $container;
            }
        }
        return null;
    }

    /**
     * A quicker way to get a container.
     * @param type $name
     * @return type
     */
    public function gc($name) {
        return $this->getContainer($name);
    }

    public function getName() {
        return $this->containerName;
    }

    /**
     * 
     * @param string $name Name of the variable.
     * @param mixed $value
     * @return DataContainer This.
     */
    public function setVariable($name, $value) {
        $this->variableData[$name] = $value;
        return $this; // Used to chain together setVariable on the same DataContainer.
    }

    /**
     * A quicker way to set a variable.
     * @param type $name
     * @param type $value
     */
    public function sv($name, $value) {
        $this->setVariable($name, $value);
        return $this;
    }

    public function getVariable($name) {
        return $this->variableData[$name];
    }

    /**
     * A quicker way to get a variable.
     * @param type $name
     * @return type
     */
    public function gv($name) {
        return $this->getVariable($name);
    }

    public function vars() {
        return $this->variableData;
    }

    public function getControllerData() {
        $details = $this->gv("ControllerDetails");
        if ($details != null) {
            if ($this->getContainer($details['name'])) {
                return $this->getContainer($details['name']);
            }
        }
    }

    public function dumpContents() {
        echo "<pre>";
        echo "Container Name: {$this->containerName}<br/>";
        echo "Container Variables: <br/>";
        print_r($this->variableData);
        echo "<br/>Container Children: <br/>";
        foreach ($this->subcontainers as $container) {
            $container->dumpContents();
        }
        echo "</pre>";
    }

}
