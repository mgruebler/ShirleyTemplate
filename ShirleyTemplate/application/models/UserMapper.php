<?php

class Application_Model_UserMapper
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
            $this->setDbTable('Application_Model_DbTable_User');
        }
        return $this->_dbTable;
    }

    // saves the User in the database
    public function save(Application_Model_User $user)
    {
        $data = array(
            'name'   => $user->getName(),
        	'lastname' => $user->getLastname(),
            'username' => $user->getUsername(),
            'password' => $user->getPassword(),
        	'email' => $user->getEmail()
        );

        if (null === ($id = $user->getID())) {
            unset($data['ID']);
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array('id = ?' => $id));
        }
    }

    // gets all Users from the database
    public function fetchAll()
    {
    	$userTable = $this->getDbTable();
    	
    	$result = $userTable->fetchAll();
        
        $users = array();
        foreach ($result as $row) {
            $user = new Application_Model_User();
            $user->setID($row->ID)
                  ->setName($row->name)
                  ->setLastname($row->lastname)
                  ->setUsername($row->username)
                  ->setPassword($row->password)
                  ->setEmail($row->email);
            $users[] = $user;
        }
        return $users;
    }
    
    // checks, if the given username already exists in the database
    public function checkUsername($username)
    {
    	$userTable = $this->getDbTable();
    	
    	$select = $userTable->select();
    	$select->where('username = ?', $username);
    	
    	$row = $userTable->fetchRow($select);
    	
    	return $row;
    }
    
    // gets a user with a certain username
 	public function findWithUsername($username)
    {
		$userTable = $this->getDbTable();
    	
    	$select = $userTable->select();
    	$select->where('username = ?', $username);
		$row = $userTable->fetchRow($select);
		
		return $row->ID;
    }
	
    public function findUserWithUsername($username)
    {
		$userTable = $this->getDbTable();
    	
    	$select = $userTable->select();
    	$select->where('username = ?', $username);
		$row = $userTable->fetchRow($select);
		
		return $row;
    }
}

