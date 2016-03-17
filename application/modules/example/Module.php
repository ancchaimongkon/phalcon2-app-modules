<?php

namespace Example;

use Phalcon\Loader;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\View;
use Phalcon\Mvc\ModuleDefinitionInterface as CreateModule;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Phalcon\Config\Adapter\Ini as ConfigInt;

// use Multiple\Plugins\SecurityPlugin as SecurityPlugin;

class Module implements CreateModule {
    
    private $moduleName = 'example';
    private $layoutName;
    private $themeName;
    
    private $config; 
    
    /* ==================================================
     * ลงทะเบียน Module auto-loader
     * Registers the module auto-loader
     * ================================================== */
    
    // ทำงานอัตโนมัติ
    public function __construct() {
        $this->config = new ConfigInt(APPLICATION_PATH . '/commons/config.ini');  // auto read config
        $this->layoutName = $this->config->module->layoutDefault;
        $this->themeName  = $this->config->module->themeDefault;
    }
    
    public function registerAutoloaders(\Phalcon\DiInterface $manager = NULL){
        
        $loader = new Loader();
        $loader->registerNamespaces(array(
            ucfirst($this->moduleName) . '\Controllers'     =>  __DIR__ . '/controllers/',
            'Multiple\Components'                           =>  APPLICATION_PATH . '/' . $this->config->application->componentsDir,
            'Multiple\Models'                               =>  APPLICATION_PATH . '/' . $this->config->application->modelsDir,
            'Multiple\Plugins'                              =>  APPLICATION_PATH . '/' . $this->config->application->pluginsDir,
        ));
        $loader->register();
        
        $manager->set('logger', function (){
            $monthNow = date('Y-m-d',time());
            $pathLog = sprintf('%s/%s/%s/%s.log', APPLICATION_PATH, $this->config->application->logsDir, $this->moduleName, $monthNow);
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
            $view->setViewsDir(__DIR__ . '/views/'); /* ตำแหน่งเก็บไฟล์ views ทั้งหมด */
            $view->setLayoutsDir($this->config->theme->themesDir . $this->config->theme->$theme); /* ตำแหน่งเก็บไฟล์ layouts ทั้งหมด */
            $view->setTemplateAfter('layouts/' . $this->layoutName); /* เลือกไฟล์ layout เริ่มต้น*/
            
            /* สร้างโฟล์เดอร์เก็บไฟล์ cache */
            $cacheDir = sprintf('%s/%s/%s/', APPLICATION_PATH, $this->config->application->cacheDir, $this->moduleName);
            if (!is_dir($cacheDir)) { mkdir($cacheDir); }
            
            $view->registerEngines(array(
                '.phtml' => function ($view, $di){
                    $volt = new VoltEngine($view, $di);
                    $volt->setOptions(array(
                        'compiledPath' => sprintf('%s/%s/%s/', APPLICATION_PATH, $this->config->application->cacheDir, $this->moduleName),
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
            $dispatcher->setDefaultNamespace(ucfirst($this->moduleName) . '\Controllers');
            
            return $dispatcher;
            
        }); 
        
    }
    
}
