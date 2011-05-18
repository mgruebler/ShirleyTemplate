<?php

require_once 'BaseTestCase.php';

class IndexControllerTest extends ControllerTestCase
{
    public function testIndexAction()
    {
        $this->dispatch('/');
        
        
        $this->assertController('index');
        $this->assertAction('index');
        $this->assertModule('default');
    }
    
    public function testReplaceAction()
    {
        $this->dispatch('/index/r');
        
        
        $this->assertController('index');
        $this->assertAction('replace');
        $this->assertModule('default');
    }
    
}

