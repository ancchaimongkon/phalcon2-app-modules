<?php

namespace Frontend\Controllers;

use Multiple\Components\CController as Controller;

class CController extends Controller {

    public function initialize(){
        
        parent::initialize();
        $this->assets->collection('cssHeader')
            ->addCss($this->getPathAssets('/themes/main/assets/style/theme-build.css'));
        
    }

}