<?php

namespace Api;

use Phalcon\Loader,
    Phalcon\Mvc\Dispatcher,
    Phalcon\Mvc\View,
    Phalcon\Mvc\ModuleDefinitionInterface as CreateModule,
    Phalcon\Config\Adapter\Ini as ConfigInt;

use Multiple\Plugins\SecurityPlugin as SecurityPlugin;

class Module implements CreateModule {
    
    private $moduleName = 'Api';
    private $config; 
    
    /* ==================================================
     * ลงทะเบียน Module auto-loader
     * Registers the module auto-loader
     * ================================================== */
    
    // ทำงานอัตโนมัติ
    public function __construct() {
        $this->config = new ConfigInt(APPLICATION_PATH . '/commons/config.ini');  // auto read config
    }
    
    public function registerAutoloaders(\Phalcon\DiInterface $manager = NULL){
        
        $loader = new Loader();
        $loader->registerNamespaces(array(
            ucfirst($this->moduleName) . '\Controllers'     =>  __DIR__ . '/controllers/',
            'Multiple\Components'                           =>  APPLICATION_PATH . '/' . $this->config->application->componentsDir,
            'Multiple\Models'                               =>  APPLICATION_PATH . '/' . $this->config->application->modelsDir,
            'Multiple\Plugins'                              =>  APPLICATION_PATH . '/' . $this->config->application->pluginsDir,
            'Multiple\Librarys'                             =>  APPLICATION_PATH . '/' . $this->config->application->libraryDir,
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
        $this->setView($manager);
        
    }
    
    /* ==================================================
     * ตั้งค่าการแสดงผล, ความปลอดภัย 
     * ================================================== */ 
    
    private function setView($manager){
        
        /* ==================================================
         * ตั้งค่าเรียกใช้งานไฟล์ View ทั้งหมด
         * ================================================== */
        
        $manager->set('view', function () {
            $view = new View();
            $view->disable();
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
            
            $security = new SecurityPlugin($manager);
            $security->setModule($this->moduleName);
            $eventsManager->attach('dispatch', $security);
            
            $dispatcher = new Dispatcher();
            $dispatcher->setEventsManager($eventsManager);
            $dispatcher->setDefaultNamespace(ucfirst($this->moduleName) . '\Controllers');
            
            return $dispatcher;
            
        }); 
        
    }
    
}
