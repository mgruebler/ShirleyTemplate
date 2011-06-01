<?php

require_once 'BaseTestCase.php';

class DownloadControllerTest extends ControllerTestCase
{
    public function testIndexAction()
    {
    	$this->loginUserTest();
    	
    	$path = BASE_PATH . "/tests/";
		$zipFileName = 'test1.zip';
		
    	$_SESSION['DownloadFileName'] = $zipFileName;
       	$_SESSION['DownloadPath'] = $path;
    	
    	$front = Zend_Controller_Front::getInstance();
    	$front->setParam('noErrorHandler', true);
        $this->dispatch('/download');
       
        $this->assertController('download');
        $this->assertAction('index');
        
        $this->assertResponseCode(200);
        
        $this->assertHeaderContains('Content-Type', 'application/zip');
        $this->assertHeaderContains('Content-Disposition', 'attachment; filename="test1.zip"');
    }
}

