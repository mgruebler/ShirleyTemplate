<?php

class DownloadController extends Zend_Controller_Action
{
    public function init()
    {
    }

    /**
     * 
     * Gets the file name and path from the session and starts the download
     * After that it clears the session again to avoid bugs
     */
    public function indexAction()
    {
    	$response = $this->getResponse();

		$response->setHeader('Content-Type', 'application/zip', true);
		$response->setHeader('Content-Disposition', 'attachment; filename="' . $_SESSION['DownloadFileName'] . '"', true);
		readfile($_SESSION['DownloadPath'].$_SESSION['DownloadFileName']);
		
		$_SESSION['DownloadPath'] = null;
		$_SESSION['DownloadFileName'] = null;
		
		// disable the view
		$this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
    }
    
	public function preDispatch()
	{
		if (!Zend_Auth::getInstance()->hasIdentity()) {
			$this->_helper->redirector('login', 'account');
		}
	}
}