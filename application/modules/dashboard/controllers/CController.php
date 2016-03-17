<?php

namespace Dashboard\Controllers;

use Multiple\Components\CController as Controller;

class CController extends Controller {

    public function initialize(){
        parent::initialize();
        $this->setTheme('adminlte');
        $this->setLayout('partials/main');
        
        $this->assets->collection('cssHeader')
            ->addCss($this->getPathAssets('/vendor/bootstrap/3.3.6/dist/css/bootstrap.min.css'))
            ->addCss($this->getPathAssets('/vendor/lightcase/2.0.2/style/lightcase.min.css'))
            ->addCss($this->getPathAssets('/themes/adminlte/assets/style/AdminLTE.min.css'))
            ->addCss($this->getPathAssets('/themes/adminlte/assets/style/skins/skin-green.min.css'));
        
        $this->assets->collection('jsFooter')
            ->addJs($this->getPathAssets('/vendor/jquery-ui/1.11.4/jquery-ui.min.js'))
            ->addJs($this->getPathAssets('/vendor/bootstrap/3.3.6/dist/js/bootstrap.min.js'))
            ->addJs($this->getPathAssets('/vendor/lightcase/2.0.2/lightcase.min.js'))  
            ->addJs($this->getPathAssets('/themes/adminlte/assets/script/app.js'))
            ->addJs($this->getPathAssets('/themes/adminlte/assets/script/pages/dashboard.js'));
        
    }

}