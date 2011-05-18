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
    
    
}

