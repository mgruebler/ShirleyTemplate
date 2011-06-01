<?php

require_once BASE_PATH.'/library/zipFiles.php';

class replaceSubstring
{
	/**
     * 
     * @id: Id of the template to get the content of it
     * @placeholders: array containing the placeholders and the input data to replace it
     * Replaces the placeholders in a text with the input data given by the user
     **/
   public function replaceSubstring($id, $placeholders)
    {    	
    	if(!isset($id))
    		return;
 		
    	$template_mapper = new Application_Model_TemplateMapper();
        $file_mapper  = new Application_Model_TemplateFileMapper();

        $template = new Application_Model_Template();
        // Find all files related to that template in the DB
        $template_mapper->find($id, $template);
        $files = $file_mapper->getTemplateData($id);

        $type = $template->getType();
        $content_array = array();
        // Docx is handled seperately from other template types
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
        	// There can be multiple files connected to one template
        	// Go through all files connected to this template, replace the placeholders
        	// and save the new text in an array for later use
	        foreach ($files as $file)
	        {
	        	$text = $file->getContent();
	        	$i = 0;
	        	
	        	foreach ($placeholders as $placeholder=>$value)
		        {
		        	$text = str_replace($placeholder, $value, $text);
		        	$i++;
		        }
		        
		        $content_array[$file->getName()] = $text;
	        }
        }
        
        $identity = Zend_Auth::getInstance()->getIdentity();
        $zip_name = $template->getName().".zip";
        
        // Save the file in BASE_PATH/public/files/username/templatename.zip
        $path = BASE_PATH."/public/files/$identity/";
       	
	    $zip_file = new zipFiles($path, $zip_name, $content_array);
	    
       	$_SESSION['DownloadFileName'] = $zip_name;
       	$_SESSION['DownloadPath'] = $path;
    }

}
    