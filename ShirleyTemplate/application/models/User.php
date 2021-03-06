<?php

class Application_Model_User
{
    protected $_ID;
    protected $_name;
    protected $_lastname;
    protected $_username;
    protected $_password;
    protected $_email;
        
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
            throw new Exception('Invalid user property');
        }
        $this->$method($value);
    }

    public function __get($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid user property');
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
    
    // set User ID
    public function setID($id)
    {
        $this->_ID = (int) $id;
        return $this;
    }

    // get User ID
    public function getID()
    {
        return $this->_ID;
    }
    
    // set Lastname of the User
    public function setLastname($lastname)
    {
        $this->_lastname = (string) $lastname;
        return $this;
    }
    
	// get Lastname of the User
    public function getLastname()
    {
        return $this->_lastname;
    }

    // set Firstname of the User
    public function setName($name)
    {
        $this->_name = (string) $name;
        return $this;
    }

    // get Firstname of the User
    public function getName()
    {
        return $this->_name;
    }

    // set Username 
    public function setUsername($name)
    {
        $this->_username = (string) $name;
        return $this;
    }

    // get Username 
    public function getUsername()
    {
        return $this->_username;
    }

    // set the Password 
    public function setPassword($password)
    {
        $this->_password = (string) $password;
        return $this;
    }

    // get the Password
    public function getPassword()
    {
        return $this->_password;
    }

    // set the Email Address
    public function setEmail($email)
    {
        $this->_email = (string) $email;
        return $this;
    }

    // get the Email Address
    public function getEmail()
    {
        return $this->_email;
    }
	
}

