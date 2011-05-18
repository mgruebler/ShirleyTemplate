<?php

require_once 'BaseTestCase.php';

class TemplateControllerTest extends ControllerTestCase
{
    public function testIndexAction()
    {
        $this->dispatch('/template/index');
        
        //$this->assertController('template');
//        $this->assertAction('index');
//        $this->assertModule('default');
    }
    public function testReplaceAction()
    {
//    	this->dispatch('/template/replace');
//        
//        $this->assertController('template');
//        $this->assertAction('index');
//        $this->assertModule('default');
    }
    
    
}

