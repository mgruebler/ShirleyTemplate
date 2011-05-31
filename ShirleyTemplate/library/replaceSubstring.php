<?php

require_once BASE_PATH.'/library/zipFiles.php';

class replaceSubstring
{
   public function replaceSubstring($id, $placeholders)
    {    	
    	if(!isset($id))
    		return;
 		
    	$template_mapper = new Application_Model_TemplateMapper();
        $file_mapper  = new Application_Model_TemplateFileMapper();

        $template = new Application_Model_Template();
        $template_mapper->find($id, $template);
        $files = $file_mapper->getTemplateData($id);

        $type = $template->getType();
        $content_array = array();
        if($type == "docx")
        {
        	$mailMerge = new Zend_Service_LiveDocx_MailMerge();
 
			$mailMerge->setUsername('ShirleyTemplate')
			          ->setPassword('ShirleyTemplateSWT11 ');
			
			$mailMerge->logIn();

        	try {
				//Input file data and name
				$mailMerge->getSoapClient()->setLocalTemplate(array(
	                'template' => base64_encode($files[0]->getContent()),
	                'format'   => 'docx',
	            ));
        	}catch (Exception $e) {
	            require_once 'Zend/Service/LiveDocx/Exception.php';
	            throw new Zend_Service_LiveDocx_Exception(
	                'Cannot set local template', 0, $e
	            );
	        }
	        
        	foreach ($placeholders as $placeholder=>$value)
	        {
	        	$mailMerge->assign($placeholder, $value);
	        	
	        }
			 
			$mailMerge->createDocument();
			 
			$content_array[$template->getName().".docx"] = $mailMerge->retrieveDocument('docx');
			$content_array[$template->getName().".pdf"] = $mailMerge->retrieveDocument('pdf');
        }
        else 
        {
	        foreach ($files as $file)
	        {
	        	$text = $file->getContent();
	        	$i = 0;
	        	
	        	foreach ($placeholders as $placeholder=>$value)
		        {
		        	$text = str_replace($placeholder, $value, $text);
		        	$i++;
		        }
		        
		        $content_array[$file->getName()] = $text; // "$text"
	        }
        }
        $identity = Zend_Auth::getInstance()->getIdentity();
        $zip_name = "$identity$id.zip";
        if(!$d = dir(BASE_PATH."/public/files/$identity"))
        	mkdir(BASE_PATH ."/public/files/$identity" , 0777);
        	
       	$_SESSION['DownloadFileName'] = "files/".$zip_name;
       	
	    $zip_file = new zipFiles("$zip_name", $content_array);
        
        //$this->_helper->redirector('');
    	/*$replaceT = new replaceTemplate();
    	$place_holder = array("#vkSUBJECT", "#vkRECPCOMPANY", "#vkRECPNAME", "#vkRECPSTREET", "#vkRECPPLY", "#vkRECPCITY", "#vkGREETING");
    	$replace_holder = array("SomeSubject", "SomeCompany", "SomeRecpName", "SomeRecpStreet", "SomeREcpply", "SomeRecpCity", "SomeGreeting");*/
    }

}
    