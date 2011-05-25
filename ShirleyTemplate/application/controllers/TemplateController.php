<?php

require_once BASE_PATH.'/library/zipFiles.php';
require_once BASE_PATH . '/library/replaceSubstring.php';

class TemplateController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */

    }

    public function indexAction()
    {
    	$templates = new Application_Model_TemplateMapper();
    	$this->view->templates = $templates->fetchAll();
    }
    

    public function fillinAction()
    {
    	$tp_id = $this->_getParam('templateid');
    	$this->view->tp_id = $tp_id;
    	
    	$req = $this->getRequest();
    	$this->view->ppost = $req->getPost();
    	$doSave = $req->getParam('submitbutton');
    	$this->view->iarray = array('submitbutton'=>$doSave	);


    	$placeholders = new Application_Model_PlaceholdersMapper();
    	$this->view->placeholders = $placeholders->fetchWithID($tp_id);
    	
    	if(isset($doSave))
    	{
    		$template_mapper = new Application_Model_TemplateMapper();
        	$file_mapper  = new Application_Model_TemplateFileMapper();
        	$template = new Application_Model_Template();
        	
       		//$template_mapper->toString();
        	//$template_mapper->find($tp_id, $template);
    		//$replaceSubstring = new replaceSubstring($tp_id,$req->getPost(),$template_mapper,$file_mapper,$template);    		
    	}
    	
    }
    
      
	public function preDispatch()
	{
		if (!Zend_Auth::getInstance()->hasIdentity()) {
			$this->_helper->redirector('login', 'account');
		}
	}
}
