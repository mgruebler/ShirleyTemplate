<?php

require_once 'BaseTestCase.php';

class DownloadControllerTest extends ControllerTestCase
{
	
	
    public function testIndexAction()
    {
        $this->dispatch('/download');
        
        //$this->assertHeader($header)
        $this->assertController('download');
        //$this->assertAction('index');
        //$this->assertModule('default');
        
        $this->assertResponseCode(200);
        
        
        //$this->assertTrue(isset($this->controller->view));
        //$this->assertNull($this->controller);
        //$this->assertNull($this->controller->testvar);

		//$this->assertTrue(file_exists(BASE_PATH.'\public\files\test.zip'));
        
    }
}

