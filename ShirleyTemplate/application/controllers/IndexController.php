<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */

    }

    public function indexAction()
    {
        // action body
    }

    public  function testdbAction()
    {
    	$template_file = new Application_Model_TemplateFileMapper();
    	$this->view->template_files = $template_file->fetchAll();
    }

}

