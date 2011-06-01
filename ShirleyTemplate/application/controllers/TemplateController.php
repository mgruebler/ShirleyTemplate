<?php

require_once BASE_PATH . '/library/replaceSubstring.php';
require_once BASE_PATH.'\library\savePlaceholdersData.php';

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
    	
    	$userid = $this->getCurrentUserID();
    	$savePlaceholdersData = new savePlaceholdersData();
    	$savePlaceholdersData->saveData("Test1", "2", $userid);
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
    		$replaceSubstring = new replaceSubstring($tp_id, $req->getPost());
    		$this->_helper->redirector('index', 'download');
    	}
    }
    
      
	public function preDispatch()
	{
		if (!Zend_Auth::getInstance()->hasIdentity()) {
			$this->_helper->redirector('login', 'account');
		}
	}
	
	public function getCurrentUserId()
	{
		if (Zend_Auth::getInstance()->hasIdentity()) {
			$identity = Zend_Auth::getInstance()->getIdentity();
		}
		$user_mapper = new Application_Model_UserMapper;
		$userid = $user_mapper->findWithUsername($identity);
		return $userid;
	}
}
