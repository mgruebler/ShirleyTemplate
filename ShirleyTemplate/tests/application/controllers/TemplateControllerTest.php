<?php

require_once 'BaseTestCase.php';

class TemplateControllerTest extends ControllerTestCase
{
    public function testIndexAction()
    {
        $this->dispatch('/template/index');
        
        $this->assertController('template');
        $this->assertAction('index');
        $this->assertModule('default');
    }
}

