<?php

require_once 'BaseTestCase.php';

class IndexControllerTest extends ControllerTestCase
{
    public function testIndexAction()
    {
        $this->dispatch('/');
        $this->assertRedirectTo('/account/login');
    }
    
}

