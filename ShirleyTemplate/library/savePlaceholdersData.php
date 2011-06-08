<?php

require_once BASE_PATH . '/application/models/UserPlaceholdersDataMapper.php';
require_once BASE_PATH . '/application/models/UserPlaceholdersData.php';

class savePlaceholdersData
{
 public function saveData($data,$placeholderid, $userid, $groupid)
    {
    	$placeholderdata = new Application_Model_UserPlaceholdersData();
    	$placeholderdata->setData($data)
    				->setUserID($userid)
    				->setPlaceholdersID($placeholderid)
    				->setGroupID($groupid);
    				
    	$placeholderdata_mapper = new Application_Model_UserPlaceholdersDataMapper();
    	$placeholderdata_mapper->save($placeholderdata);
    }
}
    