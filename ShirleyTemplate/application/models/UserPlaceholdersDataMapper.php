<?php

class Application_Model_UserPlaceholdersDataMapper
{
    protected $_dbTable;

    public function setDbTable($dbTable)
    {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->_dbTable = $dbTable;
        return $this;
    }

    public function getDbTable()
    {
        if (null === $this->_dbTable) {
            $this->setDbTable('Application_Model_DbTable_UserPlaceholdersData');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_UserPlaceholdersData $userplaceholdersdata)
    {
        $data = array(
            'data'   => $userplaceholdersdata->getData(),
            'userID' => $userplaceholdersdata->getUserID(),
        	'placeholdersID' => $userplaceholdersdata->getPlaceholdersID()
        );

        if (null === ($id = $userplaceholdersdata->getID())) {
            unset($data['ID']);
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array('id = ?' => $id));
        }
    }

    public function fetchAll()
    {
    	$userplaceholdersdataTable = $this->getDbTable();
    	
    	$result = $userplaceholdersdataTable->fetchAll();
        
        $userplaceholdersdatas = array();
        foreach ($result as $row) {
            $userplaceholderdata = new Application_Model_Placeholders();
            $userplaceholderdata->setID($row->ID)
                  ->setData($row->data)
                  ->setPlaceholderID($row->placeholderID)
                  ->setUserID($row->userID);
            $userplaceholdersdatas[] = $userplaceholderdata;
        }
        return $userplaceholdersdatas;
    }
}

