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
	        	$placeholderMapper = new Application_Model_PlaceholdersMapper();
	        	
	        	foreach ($placeholders as $placeholder=>$value)
		        {
		        	$type = $placeholderMapper->fetchTypeWithName($placeholder, $id);
		        	$replacestring = "<ST::".$type.">".$placeholder."</ST::".$type.">";
		        	$text = str_replace($replacestring, $value, $text);
		        }
		        
		        $content_array[$file->getName()] = $text;
	        }
        }
        
        $identity = Zend_Auth::getInstance()->getIdentity();
        $zip_name = $template->getName().".zip";
        $path = BASE_PATH."/public/files/$identity/";
       	
	    $zip_file = new zipFiles($path, $zip_name, $content_array);
	    
       	$_SESSION['DownloadFileName'] = $zip_name;
       	$_SESSION['DownloadPath'] = $path;
    }

}
    