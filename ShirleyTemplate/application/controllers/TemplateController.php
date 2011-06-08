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
    	$template_mapper = new Application_Model_TemplateMapper();
    	$template = new Application_Model_Template();
    	$template_mapper->find($tp_id, $template);
    	$this->view->template = $template;
    	$this->view->tp_id = $tp_id;
    	$placeholders_mapper = new Application_Model_PlaceholdersMapper();
    	$placeholders = $placeholders_mapper->fetchWithID($tp_id);
    	$form = new ZendX_JQuery_Form(array(
            'action' => $this->view->url(array('controller'=>'template','action'=>'fillin','templateid'=>$tp_id)),
            'method' => 'post',
		));
    	
    	foreach($placeholders as $placeholder)
    	{
    		
    		$t = $placeholder->getType();
    		
    		switch ($t)
    		{
    			case 'DATE':
    				$form->addElement('datepicker', $placeholder->getName(), array(
	         			'label'      => $placeholder->getName().' (dd/mm/yyyy)',
	            		'required'   => true,
    					'validators'   => array(array('validator' => 'date', 'options' => array('format' => 'dd/mm/yyyy'))),
        			));
    				break;
    			case 'NUMBER':
    				$form->addElement('text', $placeholder->getName(), array(
	         			'label'        => $placeholder->getName(),
	            		'required'     => true,
    					'validators'   => array('int'),
        			));
    				break;
    			default:
    				$form->addElement('text', $placeholder->getName(), array(
	         			'label'      => $placeholder->getName(),
	            		'required'   => true,
        			));
    				break;
    		}
    	}
        
    	$form->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Generate'
        ));
    	$this->view->form = $form;
    	
    	if($this->getRequest()->isPost())
    	{
    		$data = $this->getRequest()->getPost();
    		if ($form->isValid($data) ) 
    		{
	    		$replaceSubstring = new replaceSubstring($tp_id, $data);
	    		$userid = $this->getCurrentUserID();
	    		
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
    		else 
    		{
    			$form->populate($data);
    		}
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
