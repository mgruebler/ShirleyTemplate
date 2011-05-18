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
    
    public function replaceAction()
    {
  		$template_mapper = new Application_Model_TemplateMapper();
  		$template = new Application_Model_Template();
  		
  		$template_mapper->find(/*Needs id paramater or Template class*/ 1, $template);
  		$text = $template_file->getContent();
  		
  		//$place_holder = array("#vkAUTHOR", "#vkEMAILADDRESS", "#vkVERSION", "#vkTIMESTAMP", "#vkSHORTDESCRIPTION", "#vkTOOLNAME", "#vkNAME", "#vkURL");
  		//$temp_replace = array("Ich", "blabla@blabla.com", "2.1", "20.20.2001", "descreption of this thing", "test", "testname", "www.url.com");
  		
  		$template_result = str_replace("#vkAUTHOR", "ich", "Test #vkAUTHOR");
  		return $template_result; 
    }

}

