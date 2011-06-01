<?php

require_once 'Zend/Filter/Compress/Zip.php';

class zipFiles
{
	public function zipFiles($path, $zipFileName, $zipFilesToAdd)
    {
		if(!file_exists($path))
        	mkdir($path , 0777, true);
    	
		$zip = new ZipArchive();
		
		$zip->open("$path$zipFileName", ZipArchive::CREATE | ZipArchive::OVERWRITE);

	    foreach ($zipFilesToAdd as $fileToAddName => $fileToAddContent ) 
	    {
	    	$zip->addFromString($fileToAddName, $fileToAddContent);
		}
			
		$zip->close();
    }
}
    