<?php

require_once BASE_PATH . '/library/zipFiles.php';

class zipFilesTest extends PHPUnit_Framework_TestCase
{
	public function testCreateZipFile()
	{
		$path = BASE_PATH . "/public/files/testuser/";
		$zipFileName = 'test1.zip';
		
		$zipFiles = new zipFiles($path, $zipFileName, array( "fred1.txt" => "Hallo Fred!"
													, "fred2.txt" => "Hello again!"
													, "marco1.txt" => "Hallo Marco!")
													);
		$this->assertTrue(true);
	
		$this->assertTrue(file_exists( $path . $zipFileName ));
	}
}