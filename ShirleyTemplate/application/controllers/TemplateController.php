<?php

require_once BASE_PATH.'\library\zipFiles.php';

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
    
    public function replace($place_holder, $replace)
    {    	
    	$id = $this->_getParam('templateid');
    	if($id == 0)
    		return;
    		
        $template = new Application_Model_TemplateFile();
        $mapper  = new Application_Model_TemplateFileMapper();

        $content = $mapper->getTemplateData($id);
        $content_name = $mapper->getFileName($id);
        $mapper->find($id, $template);
        $text = $template->getData();

        $i = 0;
        $k = 0;
        foreach ($content as &$text)
        {
        	foreach ($replace as &$value)
	        {
	        	$content[$k] = str_replace($place_holder[$i], $value, $content[$k]); 
	        	$i = $i + 1;
	        }
	        $k++;
	        $i = 0;
        }
        
        if(Zend_Auth::getInstance()->hasIdentity())
        {
	        $identity = Zend_Auth::getInstance()->getIdentity();
	        $zip_name = "$identity$id.zip";
	        if(!$d = dir(BASE_PATH."/public/files/$identity"))
	        	mkdir(BASE_PATH ."/public/files/$identity" , 0777);
	        	
	       	$_SESSION['DownloadFileName'] = $zip_name;
	       	$content_array;
	       	$j = 0;
	       	foreach( $content as &$text )
	       	{
	       		$content_array[ $content_name[$j] ] = "$text";
	       		$j++;
	       	}
		    $zip_file = new zipFiles("$identity/$zip_name", $content_array);
        }
       
        //insert download
        //$this->_helper->redirector('');
    /*
    	$replaceT = new replaceTemplate();
    	$place_holder = array("#vkSUBJECT", "#vkRECPCOMPANY", "#vkRECPNAME", "#vkRECPSTREET", "#vkRECPPLY", "#vkRECPCITY", "#vkGREETING");
    	$replace_holder = array("SomeSubject", "SomeCompany", "SomeRecpName", "SomeRecpStreet", "SomeREcpply", "SomeRecpCity", "SomeGreeting");
    	
    	$replaceT->replace($place_holder, $replace_holder);*/
    }

    public function fillinAction()
    {
    	$tp_id = $this->_getParam('templateid');
    	$this->view->tp_id = $tp_id;
    	
    	$templates = new Application_Model_TemplateMapper();
    	$this->view->tp_record = $templates->fetchWithId($tp_id);
    }
    
    
    
    public function inputdatatmpAction()
    {
    	$req = $this->getRequest();

		$doSave = $req->getParam('submitbutton');
		
	    $this->view->ppost = $req->getPost();
	    
    	$this->view->iarray = array('submitbutton'=>$doSave	);
    	
    	
    }
    

}
