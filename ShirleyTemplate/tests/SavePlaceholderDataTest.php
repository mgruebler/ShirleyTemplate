<?php
require_once BASE_PATH . '/application/models/UserPlaceholdersData.php';
require_once BASE_PATH . '/application/models/UserPlaceholdersDataMapper.php';
require_once BASE_PATH . '/library/savePlaceholdersData.php';

class savePlaceholderDataTest extends PHPUnit_Framework_TestCase
{
	public function testSavePlaceholderData()
	{
		$savePlaceholdersData = new savePlaceholdersData();
		$savePlaceholdersData->saveData("testing", 1, 1, 1);
		$userplaceholder_mapper = new Application_Model_UserPlaceholdersDataMapper();
		
		$row = $userplaceholder_mapper->fetchAllTesting("testing", 1, 1, 1);
		
		$this->assertEquals("testing", $row->data);
		$this->assertEquals("1", $row->userID);
		$this->assertEquals("1", $row->placeholdersID);
		$this->assertEquals("1", $row->groupID);
	}
}