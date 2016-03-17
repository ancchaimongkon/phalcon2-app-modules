<?php

namespace Example\Controllers;

use Multiple\Components\CController as Controller;

class CController extends Controller {

    public function initialize(){
        
        parent::initialize();
        
        $this->assets->collection('cssHeader')
            ->addCss($this->getPathAssets('/assets/cyber/style/cyber-build.css'))
            ->addCss($this->getPathAssets('/themes/main/assets/style/theme-build.css'));
        
    }

}