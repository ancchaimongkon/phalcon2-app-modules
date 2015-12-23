<?php

namespace Multiple\Components;
use Phalcon\Mvc\Controller;

class CController extends Controller {
    
    public $pageTitle; 

    public function initialize(){
        $this->assets->collection('cssHeader');
        $this->assets->collection('jsHeader');
        $this->assets->collection('cssFooter');
        $this->assets->collection('jsFooter');
    }
    
    /* [Auto] เรียกใช้งาน assets Manager เมื่อมีการใช้งานไฟล์ Controller */
    protected function setAssetsBase(){
        
        $this->assets->collection('cssHeader')
            ->addCss($this->getPathAssets('/vendor/font-awesome-4.4.0/font-awesome.min.css'))
            ->addCss('http://fonts.googleapis.com/css?family=Nunito:400,300,700',false)     
            ->addCss($this->getPathAssets('/assets/style/base.css'))  
            ->addCss($this->getPathAssets('/assets/style/style.css'))
            ->addCss($this->getPathAssets('/assets/style/responsive.css'));
        
        $this->assets->collection('jsFooter')
            ->addJs($this->getPathAssets('/vendor/jquery-2.1.4/jquery.min.js'));
        
        /* 
         
        * =========================================================
        * Example
        * =========================================================

        $this->assets
            ->collection('cssHeader')
            ->addCss($this->getPathAssets('/vendor/font-awesome-4.4.0/font-awesome.min.css'))
            ->addCss('http://fonts.googleapis.com/css?family=Nunito:400,300,700',false);
        
        $this->assets
            ->collection('jsFooter')
            ->addJs($this->getPathAssets('/vendor/jquery-2.1.4/jquery.min.js'));
        
        $this->assets
            ->collection('cssHeader')
            ->addCss($this->getPathAssets('/assets/style/font-awesome.min.css'));
        $this->assets
            ->collection('jsFooter')
            ->addJs($this->getPathAssets('/assets/script/scrolltopcontrol.min.js));
         
        */
    }
    
    protected function setTheme($theme){
        $this->view->setLayoutsDir($this->config->theme->themesDir . $this->config->theme->$theme);
    }
    
    protected function setLayout($layout){
        $this->view->setTemplateAfter($layout);
    }
   
    protected function getPathAssets($path){
        return $path . '?v=' . $this->base->version;
    }

    protected function errorPage($code = 404, $message = 'Not Found !'){
        $this->view->statusCode = array($code,$message);
        $this->setLayout('error');
    }
    
}