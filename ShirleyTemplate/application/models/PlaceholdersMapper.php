<?php

class Application_Model_PlaceholdersMapper
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
            $this->setDbTable('Application_Model_DbTable_Placeholders');
        }
        return $this->_dbTable;
    }

    // saves a Placeholder with ID, name and templateID in the database
    public function save(Application_Model_Placeholders $placeholders)
    {
        $data = array(
            'name'   => $placeholders->getName(),
            'templateID' => $placeholders->getTemplateID(),
        	'englishname' => $placeholders->getEnglishname()
        );

        if (null === ($id = $placeholders->getID())) {
            unset($data['ID']);
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array('id = ?' => $id));
        }
    }

    // gets all Placeholders from the Database
    public function fetchAll()
    {
    	$placeholdersTable = $this->getDbTable();
    	
    	$result = $placeholdersTable->fetchAll();
        
        $placeholders = array();
        foreach ($result as $row) {
            $placeholder = new Application_Model_Placeholders();
            $placeholder->setID($row->ID)
                  ->setName($row->name)
                  ->setTemplateID($row->templateID)
                  ->setEnglishname($row->englishname);
            $placeholders[$row->name] = $placeholder;
        }
        return $placeholders;
    }
    
	// gets all Placeholders with the given ID 
    public function fetchWithID($tp_id)
    {
    	$placeholderTable = $this->getDbTable();
    	
    	$result = $placeholderTable->fetchAll('templateID='.$tp_id);
        
        $placeholders = array();
    	foreach ($result as $row) {
            $placeholder = new Application_Model_Placeholders();
            $placeholder->setID($row->ID)
                  ->setName($row->name)
                  ->setTemplateID($row->templateID)
                  ->setEnglishname($row->enlishname);
                  $placeholders[$row->name] = $placeholder;
        }
        return $placeholders;
    }
    
 	// gets all Placeholders with a given name and Template ID
    public function fetchWithName($name, $tp_id)
    {
    	$placeholderTable = $this->getDbTable();
    	$select = $placeholderTable->select();
    	$select->where('name = ?', $name)
    			->where('templateID = ?', $tp_id);
    	
    	$result = $placeholderTable->fetchRow($select);
        
        return (int) $result->ID;
    }
}

