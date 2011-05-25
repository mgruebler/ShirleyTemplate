<?php

class DownloadController extends Zend_Controller_Action
{
    public function init()
    {
     


    }

    public function indexAction()
    {	
    	$_SESSION['DownloadFileName'] = "files/test1.zip";
    	
    	$this->view->DownloadFileName = $_SESSION['DownloadFileName'];
    	
    //if (userHasNoPermissions) {
    //    $this->view->msg = 'This file cannot be downloaded!';
    //    $this->_forward('error', 'download');
    //	return false;
    //} 	
    
    	$response = $this->getResponse();

		$response->setHeader('Content-Type', 'application/zip', true);
		$response->setHeader('Content-Disposition', 'attachment; filename="' . $_SESSION['DownloadFileName'] . '"', true);
		//$response->setHttpResponseCode(404);
		//readfile($_SESSION['DownloadFileName']);
		
		// disable the view ... and perhaps the layout
		$this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
    }

}