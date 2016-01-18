<?php

namespace Example;

use Phalcon\Loader;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\View;
use Phalcon\Mvc\ModuleDefinitionInterface as CreateModule;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Phalcon\Config\Adapter\Ini as ConfigInt;

//use Multiple\Plugins\SecurityPlugin as SecurityPlugin;

class Module implements CreateModule {
    
    private $moduleName = 'example';
    private $layoutName;
    private $themeName;
    
    private $config; // ดึงข้อมูล Config จากไฟล์ commons/config/main.ini
    
    /* ==================================================
     * ลงทะเบียน Module auto-loader
     * Registers the module auto-loader
     * ================================================== */
    
    // ทำงานอัตโนมัติ
    public function __construct() {
        $this->config = new ConfigInt(APPLICATION_PATH . '/commons/config/main.ini');  // auto read config
        $this->layoutName = $this->config->module->layoutDefault;
        $this->themeName  = $this->config->module->themeDefault;
    }
    
    public function registerAutoloaders(\Phalcon\DiInterface $manager = NULL){
        
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
        
        $manager->set('view', function () use ($theme) {
            $view = new View();
            $view->setViewsDir(__DIR__ . '/views/');
            $view->setLayoutsDir($this->config->theme->$theme);
            $view->setTemplateAfter('layouts/' . $this->layoutName);
            $cacheDir = APPLICATION_PATH . $this->config->application->cacheDir . "/{$this->moduleName}/";
            if (!is_dir($cacheDir)) { mkdir($cacheDir); }
            $view->registerEngines(array(
                '.phtml' => function ($view, $di){
                    $volt = new VoltEngine($view, $di);
                    $volt->setOptions(array(
                        'compiledPath' => APPLICATION_PATH . $this->config->application->cacheDir . "/{$this->moduleName}/",
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
