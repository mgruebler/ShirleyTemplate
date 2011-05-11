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

    public function save(Application_Model_TemplateFile $TemplateFile)
    {
        $data = array(
            'name'   => $TemplateFile->getName(),
            'content' => $TemplateFile->getContent(),
            'size' => $TemplateFile->getSize(),
            'type' => $TemplateFile->getTy(),
        );

        if (null === ($id = $TemplateFile->getId())) {
            unset($data['id']);
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array('id = ?' => $id));
        }
    }

    public function fetchAll()
    {
    	$db = new Zend_Db_Adapter_Pdo_Mysql(array(
	        'host'     => '127.0.0.1',
	        'username' => 'root',
	        'password' => '',
	        'dbname'   => 'shirleytemplate'
    	));
        
        Zend_Db_Table::setDefaultAdapter($db);
    	$templateFilesTable = new Zend_Db_Table('template_files');
    	
    	$result = $templateFilesTable->fetchAll();
        
        $template_files   = array();
        foreach ($result as $row) {
            $template_file = new Application_Model_TemplateFile();
            $template_file->setId($row->id)
                  ->setContent($row->content)
                  ->setName($row->name)
                  ->setSize($row->size)
                  ->setType($row->type);
            $template_files[] = $template_file;
        }
        return $template_files;
    }
}

