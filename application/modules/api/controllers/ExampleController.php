<?php

namespace Api\Controllers;

class ExampleController extends CController {

    public function initialize(){
        parent::initialize();
    }
    
    public function indexAction(){
	$this->_response->setStatusCode(200, "OK");
        $this->_response->setJsonContent(
            array(
                'status' => 'OK'
            )
        );
        return $this->_response;
    }

}