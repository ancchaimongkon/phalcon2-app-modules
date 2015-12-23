<?php

namespace Frontend;

use Phalcon\Loader;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\View;
use Phalcon\Mvc\ModuleDefinitionInterface as CreateModule;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
//use Multiple\Plugins\SecurityPlugin as SecurityPlugin;

class Module implements CreateModule {
    
    private $moduleName = 'frontend';
    private $layoutName;
    private $themeName;
    
    /* ==================================================
     * ลงทะเบียน Module auto-loader
     * Registers the module auto-loader
     * ================================================== */
    
    public function registerAutoloaders(\Phalcon\DiInterface $manager = NULL){
        
        $this->layoutName = !empty($this->layoutName) ? $this->layoutName : $manager->get('config')->module->layoutDefault;
        $this->themeName  = !empty($this->themeName) ? $this->themeName : $manager->get('config')->module->themeDefault;
        
        $loader = new Loader();
        $loader->registerNamespaces(array(
            ucfirst($this->moduleName) . '\Controllers'     =>  __DIR__ . '/controllers/',
            'Multiple\Components'                           =>  APPLICATION_PATH . $manager->get('config')->application->componentsDir,
            'Multiple\Plugins'                              =>  APPLICATION_PATH . $manager->get('config')->application->pluginsDir,
        ));
        $loader->register();
        
        $manager->set('logger', function () use ($manager){
            $monthNow = date("Y-m-d",time());
            $pathLog = APPLICATION_PATH . $manager->get('config')->application->logsDir . '/' . $this->moduleName . '/' . $monthNow . '.log';
            $logger = new LogFile($pathLog);
            return $logger;
        });
        
    }
    
    /* ==================================================
     * ลงทะเบียนระบบ 
     * Registers the module-only services
     * ================================================== */
    
    public function registerServices(\Phalcon\DiInterface $manager){
       
        // ความปลอดภัย
        $this->setSecurity($manager);
        
        // การแสดงผล
        $this->setView($manager,$this->themeName);
        
    }
    
    /* ==================================================
     * ตั้งค่าการแสดงผล, ความปลอดภัย 
     * ================================================== */ 
    
    private function setView($manager,$theme){
        
        /* ==================================================
         * ตั้งค่าเรียกใช้งานไฟล์ View ทั้งหมด
         * Setting up the view component
         * ================================================== */
        
        $manager->set('view', function () use ($theme,$manager) {
            $view = new View();
            $view->setViewsDir(__DIR__ . '/views/');
            $view->setLayoutsDir($manager->get('config')->theme->themesDir . $manager->get('config')->theme->$theme);
            $view->setTemplateAfter('layouts/' . $this->layoutName);
            $view->registerEngines(array(
                '.phtml' => function ($view, $di){
                    $volt = new VoltEngine($view, $di);
                    $volt->setOptions(array(
                        'compiledPath' => APPLICATION_PATH . $di->get('config')->application->cacheDir . "/{$this->moduleName}/",
                        'compiledSeparator' => '_'
                    ));
                    return $volt;
                },
            ));
            return $view;
        });
        
    }
    
    private function setSecurity($manager){
        
        /* ==================================================
         * ตั้งค่าความปลอดภัย 
         * Setting security
         * ================================================== */   
        
        $manager->set('dispatcher', function () use ($manager) {
            $eventsManager = $manager->getShared('eventsManager');
            /*
            $security = new SecurityPlugin($manager);
            $security->setModule($this->moduleName);
            $eventsManager->attach('dispatch', $security);
            */
            $dispatcher = new Dispatcher();
            $dispatcher->setEventsManager($eventsManager);
            $dispatcher->setDefaultNamespace(ucfirst($this->moduleName) . "\Controllers");
            return $dispatcher;
        }); 
        
    }
    
}
