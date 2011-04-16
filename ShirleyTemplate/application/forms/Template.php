<?php
class Application_Form_Template extends Zend_Form
{

    public function init()
    {
        // Set the method for the display form to POST
        $this->setMethod('post');

        // Add given name element
        $this->addElement('text', 'givenName', array(
            'label'      => 'Given Name:',
            'required'   => false,
            'filters'    => array('StringTrim'),
        ));

        // Add sure name element
        $this->addElement('text', 'sureName', array(
            'label'      => 'Sure Name:',
            'required'   => false,
            'filters'    => array('StringTrim'),
        ));

        // Add the submit button
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Submit',
        ));

    }
}
?>
