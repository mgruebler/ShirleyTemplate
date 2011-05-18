<?php

require_once BASE_PATH . '/library/zipFiles.php';

class zipFilesTest extends PHPUnit_Framework_TestCase
{
	public function testCreateZipFile()
	{
		$zipFileName = 'test1.zip';
		
		$zipFiles = new zipFiles($zipFileName, array( "fred1.txt" => "Hallo Fred!"
													, "fred2.txt" => "Hello again!"
													, "marco1.txt" => "Hallo Marco!")
													);
		$this->assertTrue(true);
	
		$this->assertTrue(file_exists( BASE_PATH . "/public/files/" . $zipFileName ));	
	}
}