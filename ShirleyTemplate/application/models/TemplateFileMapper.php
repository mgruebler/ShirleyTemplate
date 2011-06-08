<?php

class Application_Model_TemplateFileMapper
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
            $this->setDbTable('Application_Model_DbTable_TemplateFile');
        }
        return $this->_dbTable;
    }

    // saves a File into the Database with ID, name, templateID und data (content)
    public function save(Application_Model_TemplateFile $TemplateFile)
    {
        $data = array(
            'name'   => $TemplateFile->getName(),
            'templateID' => $TemplateFile->getTemplateID(),
            'data' => $TemplateFile->getData()
        );

        if (null === ($id = $TemplateFile->getID())) {
            unset($data['ID']);
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array('id = ?' => $id));
        }
    }

    // gets all Files from the database
    public function fetchAll()
    {
    	$templateTable = $this->getDbTable();
    	
    	$result = $templateTable->fetchAll();
        
        $templates = array();
        foreach ($result as $row) {
            $template = new Application_Model_TemplateFile();
            $template->setID($row->ID)
                  ->setName($row->name)
                  ->setTemplateID($row->templateID)
                  ->setContent($row->data);
            $templates[] = $template;
        }
        return $templates;
    }
    
    // gets a file with the given ID
    public function find($id, Application_Model_TemplateFile $template_file)
    {
    	$result = $this->getDbTable()->find($id);
    	if (0 == count($result))
    	{
    		return;
    	}
    	
    	$row = $result->current();
    	$template_file->setID($row->ID)
    				  ->setTemplateID($row->templateID)
    				  ->setName($row->name)
    				  ->setContent($row->data);
    }
    
    // gets all Files from one template
    public function getTemplateData($id)
	{
		$templateDB = $this->getDbTable();
    	$select = $templateDB->select();
    	$select->where('templateid = ?', $id);
    	
		$rowset = $templateDB->fetchAll($select);
		
		$files = array();
		
		foreach($rowset as $row) {
		    $file = new Application_Model_TemplateFile();
            $file->setID($row->ID)
                  ->setName($row->name)
                  ->setTemplateID($row->templateID)
                  ->setContent($row->data);
            $files[] = $file;
		}
		return $files;
    }
    
    // gets the name of a file with the given ID 
	public function getFileName($id)
	{
    	$select = $this->getDbTable()->select();
    	$select->where('templateid = ?', $id);
    	
    	//$row = $this->getDbTable()->fetchRow($select);
		$rowset = $this->getDbTable()->fetchAll($select);
		$row = $rowset->current();
		$data;
		
		for( $i = 0; $i < $rowset->count(); $i++) {
		    $row = $rowset[$i];
		    $data[$i] = $row->name;
		    echo "$row->name";
		}
		return $data;
    }
}

