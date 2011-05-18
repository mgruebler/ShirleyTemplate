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

    	header('Content-Type: text/html');
		header('Content-Disposition: attachment; filename="' . $_SESSION['DownloadFileName'] . '"');
		readfile($_SESSION['DownloadFileName']);
		
		// disable the view ... and perhaps the layout
		$this->view->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
    }

}