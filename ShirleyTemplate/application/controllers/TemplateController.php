<?php

require_once BASE_PATH . '/library/replaceSubstring.php';
require_once BASE_PATH.'/library/savePlaceholdersData.php';

class TemplateController extends Zend_Controller_Action
{
    public function init()
    {
        /* Initialize action controller here */
    }

    /**
     * 
     * Starts the index action
     **/
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
    	$placeholders_mapper = new Application_Model_PlaceholdersMapper();
    	$placeholders = $placeholders_mapper->fetchWithID($tp_id);
    	$form = new Zend_Form(array(
            'action' => $this->view->url(array('controller'=>'template','action'=>'fillin','templateid'=>$tp_id)),
            'method' => 'post',
		));
    	
    	foreach($placeholders as $placeholder)
    	{
    		$form->addElement('text', $placeholder->getName(), array(
	         	'label'      => $placeholder->getName(),
	            'required'   => true,
        	));
    	}
    	
    	$form->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Generate'
        ));
        
        
    	$form->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Generate'
        ));
    	$this->view->form = $form;
    	
    	if($this->getRequest()->isPost())
    	{
    		$replaceSubstring = new replaceSubstring($tp_id, $this->getRequest()->getPost());
    		$userid = $this->getCurrentUserID();
    		$data = $this->getRequest()->getPost();
			foreach ( $data as  $keyoutput => $output )
    		{
    			$placeholdersMapper = new Application_Model_PlaceholdersMapper();
    			$placeholderID = $placeholdersMapper->fetchWithName($keyoutput, $tp_id);
    			
    			$savePlaceholdersData = new savePlaceholdersData();
    			if($keyoutput!="submit")
    				$savePlaceholdersData->saveData($data["$keyoutput"], $placeholderID, $userid);
    		}
    		$this->_helper->redirector('index', 'download');
    	}
    }
    
    /**
     * 
     * gets called automatically before calling an action and redirects 
     * the user to the login page if he is not logged in yet 
    **/
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
		$identity = Zend_Auth::getInstance()->getIdentity();
		$user_mapper = new Application_Model_UserMapper;
		$userid = $user_mapper->findWithUsername($identity);
		return $userid;
	}
}
