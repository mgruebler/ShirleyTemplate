<?php

require_once BASE_PATH . '/application/models/UserPlaceholdersDataMapper.php';
require_once BASE_PATH . '/application/models/UserPlaceholdersData.php';

class savePlaceholdersData
{
 public function saveData($data,$placeholderid, $userid)
    {
    	$placeholderdata = new Application_Model_UserPlaceholdersData();
    	$placeholderdata->setData($data)
    				->setUserID($userid)
    				->setPlaceholdersID($placeholderid);
    				
    	$placeholderdata_mapper = new Application_Model_UserPlaceholdersDataMapper();
    	$placeholderdata_mapper->save($placeholderdata);
    }
}
    