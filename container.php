<?php
/**
 * Forked from "Fogo" but completely changed by warmans.
 * 
 * A prototype for a micro Dependency Injection (DI) Container.
 * 
 * @license MIT License
 * @copyright Copyright (c) 2012, Jason Johnson <jason@period-three.com>
 * @version 0.1
 */

class Container {
	private $_components = array();
	
    public function addComponent($className) {
        $this->_components[$className] = new NamedComponent($this, $className);
        return $this->_components[$className];
    }

    public function getComponent($className){
        return $this->_components[$className];
    }

    public function getInstance($className){
        return $this->_components[$className]->getInstance();
    }
}

abstract class ComponentAbstract {
    
    private $_container;
    private $_className;
    
    abstract public function addConstructor($val);   
    abstract public function addSharedConstructor($componentName);   
    abstract public function getInstance();   
}

class NamedComponent extends ComponentAbstract {
    
    private $_constructors = array();
    
    public function __construct($container, $className){
        $this->_container = $container;
        $this->_className = $className;
    }
    
    public function addConstructor($val){
        $this->_constructors[] = $val;
        return $this;
    }
    
    public function addSharedConstructor($className){
        $this->_constructors[] = $this->_container->getComponent($className)->getInstance();
        return $this;
    }      
    
    public function getInstance(){		
		$class = new ReflectionClass($this->_className);
		return  $class->newInstanceArgs($this->_constructors);
    }
}