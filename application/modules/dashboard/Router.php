<?php

use Phalcon\Mvc\Router\Group;

class DashboardRouter extends Group {
    
    private $moduleDefault = 'dashboard';
    private $controllerDefault;
    private $actionDefault;
    
    public function __construct($config) {
        $this->controllerDefault = $config->router->controllerDefault;
        $this->actionDefault     = $config->router->actionDefault;
        parent::__construct();
    }
    
    public function initialize(){
        
        // Default paths
        $this->setPaths(array(
            'module' => $this->moduleDefault,
        ));
        
        $this->setPrefix('/' . $this->moduleDefault);
         
        $this->add('/:controller/:action/:params', array(
            'module'        => $this->moduleDefault,
            'controller'    => 1,
            'action'        => 2,
            'params'        => 3
        ));
        
        $this->add('/:controller/:action/', array(
            'module'        => $this->moduleDefault,
            'controller'    => 1,
            'action'        => 2
        ));
        
        $this->add('/:controller/:action', array(
            'module'        => $this->moduleDefault,
            'controller'    => 1,
            'action'        => 2
        ));
        
        $this->add('/:controller/', array(
            'module'        => $this->moduleDefault,
            'controller'    => 1,
            'action'        => $this->actionDefault
        ));
        
        $this->add('/:controller', array(
            'module'        => $this->moduleDefault,
            'controller'    => 1,
            'action'        => $this->actionDefault
        ));
        
        $this->add('/', array(
            'module'        => $this->moduleDefault,
            'controller'    => $this->controllerDefault,
            'action'        => $this->actionDefault
        ));
        
        $this->add('', array(
            'module'        => $this->moduleDefault,
            'controller'    => $this->controllerDefault,
            'action'        => $this->actionDefault
        ));
        
    }
    
}
