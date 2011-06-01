<?php

require_once 'BaseTestCase.php';
require_once 'Zend/Filter/Compress/Zip.php';

class TemplateControllerTest extends ControllerTestCase
{
    public function testIndexAction()
    {
    	$this->loginUserTest();
        $this->dispatch('/template/index');
        
        $this->assertController('template');
        $this->assertAction('index');
        $this->assertModule('default');
    }     
}

