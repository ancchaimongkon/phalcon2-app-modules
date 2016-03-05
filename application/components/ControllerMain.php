<?php

namespace Multiple\Components;
use Multiple\Components\CController;

class ControllerMain extends CController {
    
    public function initialize(){
        
        parent::initialize();
        $this->setAssetsBase();
        $this->setLayout('partials/main');
        
        /* 
         
        * =========================================================
        * Example
        * =========================================================

        $this->assets
            ->collection('cssHeader')
            ->addCss($this->getPathAssets('/vendors/fortawesome.4.3.0/font-awesome.min.css'))
            ->addCss('http://fonts.googleapis.com/css?family=Nunito:400,300,700',false);
        
        $this->assets
            ->collection('jsFooter')
            ->addJs($this->getPathAssets('/vendors/jquery-2.1.4/jquery.min.js'));
        
        $this->assets
            ->collection('cssHeader')
            ->addCss($this->getPathAssets('/public/assets/css/font-awesome.min.css'));
        $this->assets
            ->collection('jsFooter')
            ->addJs($this->getPathAssets('/public/assets/js/scrolltopcontrol.min.js));
         
        */
        
    }
    
}