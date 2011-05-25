<?php

require_once 'BaseTestCase.php';

class DownloadControllerTest extends ControllerTestCase
{
    public function testIndexAction()
    {
    	// todo: generate file and set file name
    	$_SESSION['DownloadFileName'] = "files/test1.zip";
    	
    	$front = Zend_Controller_Front::getInstance();
    	$front->setParam('noErrorHandler', true);
        $this->dispatch('/download');
       
        $this->assertController('download');
        $this->assertAction('index');
        
        $this->assertResponseCode(200);
        
        $this->assertHeaderContains('Content-Type', 'application/zip');
        $this->assertHeaderContains('Content-Disposition', 'attachment; filename="files/test1.zip"');
    }
}

