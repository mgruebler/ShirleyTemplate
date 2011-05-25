<?php

require_once 'Zend/Filter/Compress/Zip.php';

class zipFiles
{
	public function zipFiles( $zipFileName, $zipFilesToAdd )
    {
    	$zipFileName = BASE_PATH . '/public/files/' . $zipFileName;
    	
		$zip = new ZipArchive();
		
		$zip->open($zipFileName, ZipArchive::CREATE | ZipArchive::OVERWRITE);

	    foreach ($zipFilesToAdd as $fileToAddName => $fileToAddContent ) 
	    {
	    	$zip->addFromString($fileToAddName, $fileToAddContent);
		}
			
		$zip->close();
		
    }
}
    