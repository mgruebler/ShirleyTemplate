<?php

class Application_Form_Register extends Zend_Form
{

    public function init()
    {
//	$form = new Zend_Form;
	/*$this->setAction('/index')
		 ->setMethod('post');*/
	 
	 // Add an email element	 
     $this->addElement('text', 'email', array(
         	'label'      => 'Your email address:',
            'required'   => true,
            'filters'    => array('StringTrim'),
            'validators' => array(
            'EmailAddress',
            )
        ));
		
		$this->addElement('text', 'username', array(
            'label'      => 'Your username:',
            'required'   => true,
        ));
        
        $this->addElement('password', 'password', array(
            'label'      => 'Your password:',
            'required'   => true,
            'validators' => array(array('validator' => 'StringLength', 'options' => array(6, 20)))
        ));
		
		$this->addElement('text', 'name', array(
            'label'      => 'Your name:',
            'required'   => true,
        ));
		
		$this->addElement('text', 'lastname', array(
            'label'      => 'Your lastname:',
            'required'   => true,
        ));
        
                
		// Add the submit button
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Register and login!'
        ));
     
        // And finally add some CSRF protection
        //$this->addElement('hash', 'csrf', array(
        //    'ignore' => true,
        //));
        		
	//echo $form->render($view);
    }


}

