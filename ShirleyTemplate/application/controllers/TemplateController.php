<?php

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
    	
    	$templates = new Application_Model_TemplateMapper();
    	$this->view->tp_record = $templates->fetchWithId($tp_id);
    }
}

