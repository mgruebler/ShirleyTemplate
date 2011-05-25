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

    public function save(Application_Model_Placeholders $placeholders)
    {
        $data = array(
            'name'   => $placeholders->getName(),
            'templateID' => $placeholders->getTemplateID()
        );

        if (null === ($id = $placeholders->getID())) {
            unset($data['ID']);
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array('id = ?' => $id));
        }
    }

    public function fetchAll()
    {
    	$placeholdersTable = $this->getDbTable();
    	
    	$result = $placeholdersTable->fetchAll();
        
        $placeholders = array();
        foreach ($result as $row) {
            $placeholder = new Application_Model_Placeholders();
            $placeholder->setID($row->ID)
                  ->setName($row->name)
                  ->setTemplateID($row->templateID);
            $placeholders[$row->name] = $placeholder;
        }
        return $placeholders;
    }
    
    
    public function fetchWithID($tp_id)
    {
    	$placeholderTable = $this->getDbTable();
    	
    	$result = $placeholderTable->fetchAll('templateID='.$tp_id);
        
        $placeholders = array();
    	foreach ($result as $row) {
            $placeholder = new Application_Model_Placeholders();
            $placeholder->setID($row->ID)
                  ->setName($row->name)
                  ->setTemplateID($row->templateID);
                  $placeholders[$row->name] = $placeholder;
        }
        return $placeholders;
    }
}

