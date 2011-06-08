<?php

class Application_Model_UserPlaceholdersData
{
    protected $_ID;
    protected $_userID;
    protected $_placeholdersID;
    protected $_data;
    protected $_groupID;

    public function __construct(array $options = null)
    {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set($name, $value)
    {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid placeholder data property');
        }
        $this->$method($value);
    }

    public function __get($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid placeholder data property');
        }
        return $this->$method();
    }

    public function setOptions(array $options)
    {
        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }
        return $this;
    }
    
    public function setID($id)
    {
        $this->_ID = (int) $id;
        return $this;
    }

    public function getID()
    {
        return $this->_ID;
    }
    
    public function setUserID($id)
    {
        $this->_userID = (int) $id;
        return $this;
    }

    public function getUserID()
    {
        return $this->_userID;
    }
	
    public function setPlaceholdersID($id)
    {
        $this->_placeholdersID = (int) $id;
        return $this;
    }

    public function getPlaceholdersID()
    {
        return $this->_placeholdersID;
    }

    public function setData($data)
    {
        $this->_data = (string) $data;
        return $this;
    }

    public function getData()
    {
        return $this->_data;
    }
    
        public function setGroupID($groupID)
    {
        $this->_groupID = (int) $groupID;
        return $this;
    }

    public function getGroupID()
    {
        return $this->_groupID;
    }

}

