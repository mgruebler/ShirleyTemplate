<?php

require_once 'BaseTestCase.php';

class DownloadControllerTest extends ControllerTestCase
{
	
	
    public function testIndexAction()
    {
    	$front = Zend_Controller_Front::getInstance();
    	$front->setParam('noErrorHandler', true);
        $this->dispatch('/download');
        
        //$this->assertHeader($header)
        $this->assertController('download');
        $this->assertAction('index');
        
        $this->assertResponseCode(200);
        
        $response = $this->getResponse();
        
        print('begin response');
        print($response->__toString());
        print('end response');
        
        foreach ($response->getHeaders() as $header=>$headerdata)
        {
        	print('bla');
        	print($header);
        	print($headerdata);
        }
    }
}

