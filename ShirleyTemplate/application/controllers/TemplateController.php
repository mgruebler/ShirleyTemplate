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
    
	/*public function replaceAction()
    {
  		$template_filemapper = new Application_Model_TemplateFileMapper();
  		$template_file = new Application_Model_TemplateFile();
  		
  		$template_filemapper->find($template_file->getId(), $template_file);
  		$text = $template_file->getContent();
  		
  		//$place_holder = array("#vkAUTHOR", "#vkEMAILADDRESS", "#vkVERSION", "#vkTIMESTAMP", "#vkSHORTDESCRIPTION", "#vkTOOLNAME", "#vkNAME", "#vkURL");
  		//$temp_replace = array("Ich", "blabla@blabla.com", "2.1", "20.20.2001", "descreption of this thing", "test", "testname", "www.url.com");
  		
  		$template_result = str_replace("#vkAUTHOR", "ich", "Test #vkAUTHOR");
  		return $template_result;    	
    }*/

}