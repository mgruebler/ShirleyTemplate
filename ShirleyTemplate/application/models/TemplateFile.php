<?php

class Application_Model_TemplateFile
{
    protected $_ID;
    protected $_name;
    protected $_templateID;
    protected $_content;
    
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
    
    // set File ID
    public function setID($id)
    {
        $this->_ID = (int) $id;
        return $this;
    }

    // get File ID
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

    // set File name
    public function setName($name)
    {
        $this->_name = (string) $name;
        return $this;
    }

    // get File name
    public function getName()
    {
        return $this->_name;
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
    
    // get File content
    public function getContent()
    {
    	return $this->_content;
    }
    
    // set File content
    public function setContent($cont)
    {
    	$this->_content = $cont;
    	return $this;
    }
}

