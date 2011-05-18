<?php 
class Application_Form_Login extends Zend_Form
{
    public function init()
    {
		$this->addElement('text', 'username', array(
            'label'      => 'Your username:',
            'required'   => true,
        ));
        
        $this->addElement('password', 'password', array(
            'label'      => 'Your password:',
            'required'   => true,
            'validators' => array(array('validator' => 'StringLength', 'options' => array(6, 20)))
        ));
	
		
	
		// Add the submit button
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Login!',
			'class' => 'button'
        ));
		
		
		
		//<a href="this.form.submit()">Abschicken</a>


        // And finally add some CSRF protection
        //$this->addElement('hash', 'csrf', array(
        //    'ignore' => true,
        //));
    }
}
 