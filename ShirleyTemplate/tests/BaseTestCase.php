<?php
require_once 'Zend/Application.php';
require_once 'Zend/Test/PHPUnit/ControllerTestCase.php';

abstract class ControllerTestCase extends Zend_Test_PHPUnit_ControllerTestCase
{
    public $_application;

    public function setUp()
    {
        $this->_application = new Zend_Application(
            APPLICATION_ENV,
            APPLICATION_PATH . '/configs/application.ini'
        );

        $this->bootstrap = array($this, 'appBootstrap');
        
        
        
        parent::setUp();
    }

    public function appBootstrap()
    {
        $this->_application->bootstrap();
        
        /**
         * Fix for ZF-8193
         * http://framework.zend.com/issues/browse/ZF-8193
         * Zend_Controller_Action->getInvokeArg('bootstrap') doesn't work
         * under the unit testing environment.
         */
        $front = Zend_Controller_Front::getInstance();
        if($front->getParam('bootstrap') === null) {
            $front->setParam('bootstrap', $this->_application->getBootstrap());
        }
        
        $this->createDatabase();
    }
    
    public function createDatabase()
    {
    	$dbAdapter = Zend_Db_Table::getDefaultAdapter();
    	
    	$sql = file_get_contents('dump.sql', true);
        
        $dbAdapter->getConnection()->exec($sql);
    }
    
    public function loginUserTest()
    {
    	$this->loginUser("bernd", "hirschmann");
    }
    
	public function loginUser($user, $password)
    {
        $this->request->setMethod('POST')
                      ->setPost(array(
                          'username' => $user,
                          'password' => $password,
                      ));
        $this->dispatch('/account/login');
        $this->assertRedirectTo('/');
 
        $this->resetRequest()
             ->resetResponse();
 
        $this->request->setPost(array());
    }
}
?>