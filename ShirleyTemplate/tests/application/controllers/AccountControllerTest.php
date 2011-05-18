<?php

require_once 'BaseTestCase.php';

class AccountControllerTest extends ControllerTestCase
{
    public function testLoginAction()
    {
        $this->dispatch('/account/login');
        
        
        $this->assertController('account');
        $this->assertAction('login');
        $this->assertModule('default');
    }
}