<?php

require_once 'BaseTestCase.php';

class DownloadControllerTest extends ControllerTestCase
{
	public function loginUser($user, $password)
    {
        $this->request->setMethod('POST')
                      ->setPost(array(
                          'username' => $user,
                          'password' => $password,
                      ));
        $this->dispatch('/account/login');
        $this->assertRedirectTo('/');
 
        $this->resetRequest()
             ->resetResponse();
 
        $this->request->setPost(array());
    }
    
    public function testIndexAction()
    {
    	$this->loginUser("bernd", "hirschmann");
    	
    	$path = BASE_PATH . "/tests/";
		$zipFileName = 'test1.zip';
		
		echo $path;
		
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

