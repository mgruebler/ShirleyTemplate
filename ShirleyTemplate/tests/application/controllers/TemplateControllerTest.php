<?php

require_once 'BaseTestCase.php';
require_once 'Zend/Filter/Compress/Zip.php';

define('OELF', 11);

class TemplateControllerTest extends ControllerTestCase
{
    public function testIndexAction()
    {
    	$this->loginUserTest();
        $this->dispatch('/template/index');
        
        $this->assertController('template');
        $this->assertAction('index');
        $this->assertModule('default');
    }

    public function testIndexActionShouldReturnOelfLis()
    {
    	$this->loginUserTest();
    	$this->dispatch('/template/index');
    	
    	$this->assertQueryCount('li.template-link', OELF);
    }
    
    public function testFillInFormTextboxCount()
    {
    	$this->loginUserTest();
    	
    	$this->dispatch('/template/fillin/templateid/14');
        $this->assertController('template');
        $this->assertAction('fillin');
        
        $this->assertQueryCount('input[type="text"]', 7);
    }
    
 	public function FillInForm($tmp_id)
    {
     	$array = array(	'software' => 'software_test',
     					'licensee' =>'license_test',
                   		'company'=> 'company_test',
                   		'date' => 'date_test',
                   		'time' => 'time_test',
                    	'city' => 'city_test',
                    	'country' => 'country_test',
                    	'submitbutton' => 'Generate');

   		$this->request->setMethod('POST')
                      ->setPost($array);      
     
        $this->assertController('template');       
    }   

    public function testFillInLinks()
    {
     	$tp_id  = 14;
        $this->dispatch('/template/fillin/templateid/'.$tp_id);
        $this->assertController('template');
        $this->assertAction('fillin');
        $this->FillInForm($tp_id);
    
     	$this->dispatch('/template/fillin/templateid');
     	$this->assertController('error');
    }
}

