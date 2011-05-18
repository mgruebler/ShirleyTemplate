<?php
class AccountController extends Zend_Controller_Action
{
	public function getForm()
	{
		return new Application_Form_Login(array(
            'action' => '/account/login',
            'method' => 'post',
		));
	}

	public function getAuthAdapter(array $params)
	{
		// Leaving this to the developer...
		// Makes the assumption that the constructor takes an array of
		// parameters which it then uses as credentials to verify identity.
		// Our form, of course, will just pass the parameters 'username'
		// and 'password'.
		$database = Zend_Db_Table::getDefaultAdapter();
		
		$authAdapter = new Zend_Auth_Adapter_DbTable(
		    $database,
		    'User',
		    'username',
		    'password'
		    );
		    
		// Set the input credential values (e.g., from a login form)
		$authAdapter
		    ->setIdentity($params['username'])
		    ->setCredential($params['password'])
		;
		
		return $authAdapter;
	}

	public function preDispatch()
	{
		if (Zend_Auth::getInstance()->hasIdentity()) {
			// If the user is logged in, we don't want to show the login form;
			// however, the logout action should still be available
			if ('logout' != $this->getRequest()->getActionName()) {
				$this->_helper->redirector('index', 'index');
			}
		} else {
			// If they aren't, they can't logout, so that action should
			// redirect to the login form
			if ('logout' == $this->getRequest()->getActionName()) {
				$this->_helper->redirector('index');
			}
		}
	}
	
	public function indexAction()
	{
		$this->_helper->redirector('index','index');
	}
	
	public function loginAction()
    {
        $request = $this->getRequest();
        

        // Check if we have a POST request
        if (!$request->isPost()) {
        	$this->view->form = $this->getForm();
            return $this->render('login');
        }

        // Get our form and validate it
        $form = $this->getForm();
        if (!$form->isValid($request->getPost())) {
            // Invalid entries
            $this->view->form = $form;
            return $this->render('login'); // re-render the login form
        }

        // Get our authentication adapter and check credentials
        $adapter = $this->getAuthAdapter($form->getValues());
        $auth    = Zend_Auth::getInstance();
        $result  = $auth->authenticate($adapter);
        if (!$result->isValid()) {
            // Invalid credentials
            $form->setDescription('Invalid credentials provided');
            $this->view->form = $form;
            echo "<script type='text/javascript'>alert('Invalid credentials provided');</script>";
            return $this->render('login'); // re-render the login form
        }

        // We're authenticated! Redirect to the home page
        $this->_helper->redirector('index', 'index');
    }
    
	public function logoutAction()
    {
        Zend_Auth::getInstance()->clearIdentity();
        $this->_helper->redirector('login', 'account'); // back to login page
    }
    
	public function registerAction()
    {    
		$auth = Zend_Auth::getInstance();
			
		$authStorage = $auth->getStorage();
		if ($auth->hasIdentity())
		{
			$url =array('controller'=>'index', 'action'=>'index');
			return $this->_helper->redirector->gotoRoute($url);
		}
	
        $request = $this->getRequest();
        $form = new Application_Form_Register();
 		
 		$this->view->form = $form;
 		
        if ($this->getRequest()->isPost()) 
		{
        	$formData = $this->getRequest()->getPost();
        	
     	  	if ($form->isValid($formData) ) 
			{
            	$email = $form->getValue('email');
            	$username = $form->getValue('username');
            	$password = $form->getValue('password');
            	$name = $form->getValue('name');
            	$lastname = $form->getValue('lastname');
            	
            	
            	$user_mapper = new Application_Model_UserMapper();
            	
            	$result = $user_mapper->checkUsername($username);
            	if(!$result)
            	{           		            	
            		// Speichern in die Datenbank:  
            		$user = new Application_Model_User();
            		$user ->setName($name)
		                  ->setLastname($lastname)
		                  ->setUsername($username)
		                  ->setPassword($password)
		                  ->setEmail($email);       	
                    $user_mapper->save($user);
                    
      	            //einloggen
					$auth = Zend_Auth::getInstance();
					
					$adapter = $this->getAuthAdapter($form->getValues());
				
					$adapter->setIdentity($username)->setCredential($password);
				
					$result = $auth->authenticate($adapter);
					$identity = $adapter->getResultRowObject();
					              
            		$url =array('controller'=>'index', 'action'=>'index');
                	return $this->_helper->redirector->gotoRoute($url);
               } 
               else
               {
                  echo "<script type='text/javascript'>alert('Email and/or username already exists!');</script>";
					
                  $form->populate($formData);
               }
            }
            else 
			{
      	        $form->populate($formData);
            }			
				
        }
 
    }
}