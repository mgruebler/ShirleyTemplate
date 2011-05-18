<?php

class Application_Model_Template
{
    protected $_ID;
    protected $_name;
    protected $_userID;
    protected $_type;

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
            throw new Exception('Invalid template_file property');
        }
        $this->$method($value);
    }

    public function __get($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid template_file property');
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

    public function setName($name)
    {
        $this->_name = (string) $name;
        return $this;
    }

    public function getName()
    {
        return $this->_name;
    }

    public function setType($type)
    {
        $this->_type = $type;
        return $this;
    }

    public function getType()
    {
        return $this->_type;
    }
    
    public function getPlaceHolder()
    {
    	return $this->_place_holder;
    }
    
    public function setPlaceHolder(array $place_holder)
    {
    	$this->_place_holder = (array)$place_holder;
    	return $this;
    }
}

