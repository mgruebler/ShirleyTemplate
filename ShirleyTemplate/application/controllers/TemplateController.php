<?php

require_once BASE_PATH . '/library/replaceSubstring.php';
require_once BASE_PATH.'/library/savePlaceholdersData.php';

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
    
	/**
	 * 
	 * Replaces all the placeholders and saves them in the database
	 */ 
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
    		
    		$userid = $this->getCurrentUserID();
    		$data = $req->getPost();
			foreach ( $data as  $keyoutput => $output )
    		{
    			$placeholdersMapper = new Application_Model_PlaceholdersMapper();
    			$placeholderID = $placeholdersMapper->fetchWithName($keyoutput, $tp_id);
    			
    			$savePlaceholdersData = new savePlaceholdersData();
    			if($keyoutput!="submitbutton")
    				$savePlaceholdersData->saveData($data["$keyoutput"], $placeholderID, $userid);
    		}
    		$this->_helper->redirector('index', 'download');
    	}
    }
    
	public function preDispatch()
	{
		if (!Zend_Auth::getInstance()->hasIdentity()) {
			$this->_helper->redirector('login', 'account');
		}
	}
	
	/**
	 * 
	 * gets the UserID of the currently logged in User
	 */
	public function getCurrentUserId()
	{
		//if($identity = Zend_Auth::getInstance()->getIdentity())
		{
			$identity = Zend_Auth::getInstance()->getIdentity();
			$user_mapper = new Application_Model_UserMapper;
			$userid = $user_mapper->findWithUsername($identity);
			return $userid;
		}
		//else
		{
			//return 1;
		}
	}
}
