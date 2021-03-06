<?php

class Application_Model_Placeholders
{
    protected $_ID;
    protected $_name;
    protected $_templateID;
    protected $_type;    protected $_englishname;

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
            throw new Exception('Invalid placeholder property');
        }
        $this->$method($value);
    }

    public function __get($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid placeholder property');
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
    
    // set Placeholder ID
    public function setID($id)
    {
        $this->_ID = (int) $id;
        return $this;
    }
    
	// get Placeholder ID
    public function getID()
    {
        return $this->_ID;
    }
    
    // set Template ID
    public function setTemplateID($id)
    {
        $this->_templateID = (int) $id;
        return $this;
    }

    // get Template ID
    public function getTemplateID()
    {
        return $this->_templateID;
    }

    // set Placeholder Name
    public function setName($name)
    {
        $this->_name = (string) $name;
        return $this;
    }

    // get Placeholder Name
    public function getName()
    {
        return $this->_name;
    }
    

	// set Placeholder English Name
    public function setEnglishname($name)
    {
        $this->_name = (string) $name;
        return $this;
    }

    // get Placeholder English Name
    public function getEnglishname()
    {
        return $this->_name;
    }

    public function setType($type)
    {
        $this->_type = (string) $type;
        return $this;
    }

    public function getType()
    {
        return $this->_type;
    }
}

