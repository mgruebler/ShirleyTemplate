<?php

require_once 'Zend/Filter/Compress/Zip.php';

class zipFiles
{
	/**
	 * 
	 * Creates a zip file in a specific dir (creates the directory if its not existing) 
	 * @param $path: Holds the path in which the zip file will be created
	 * @param $zipFileName: Contains the zip file name
	 * @param $zipFilesToAdd: Holds all files and their respective content
	 */
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
    