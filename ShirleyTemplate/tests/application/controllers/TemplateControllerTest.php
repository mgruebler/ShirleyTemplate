<?php

require_once 'BaseTestCase.php';
require_once 'Zend/Filter/Compress/Zip.php';

define('OELF', 5);

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
    
    public function testFillInShouldCheckForRequired()
    {
    	$this->loginUserTest();
    	
    	$array = array(	'Vorname' => '',
     					'Nachname' =>'',
                   		'Geburtstag'=> '',
                   		'Familienstand' => '',
                   		'Staatsbürgerschaft' => '',
                    	'Anschrift' => '',
                    	'Postleitzahl_ohne_A' => '',
                    	'Wohnort' => '',
						'Maturajahrgang' => '',
				    	'Berufserfahrung' => '',
				    	'Führerschein' => '',
				    	'Fremdsprachen' => '',
				    	'Monat_Studienbeginn' => '',
				    	'Jahr_Studenbeginn' => '',
				    	'Studienrichtung' => '',
				    	'Universität' => '',  
				    	'Monat_der_Publikation' => '',
				    	'Jahr_Publikation' => '',
				    	'Autoren_der_Publikation' => '',
				    	'Name_der_Publikation' => '',
				    	'Ort_der_Publikation' => '',
				    	'Land_der_Publikation' => '',
				    	'Ort' => '');

   		$this->request->setMethod('POST')
                      ->setPost($array);   

        $this->dispatch('/template/fillin/templateid/13');
    	
        $this->assertController('template');
        $this->assertAction('fillin');
        
        $this->assertQueryCount('ul.errors', 23);
    }
        
    /*public function testFillInShouldCheckForValidDate()
    {
    	$this->loginUserTest();
    	
    	$array = array(	'Vorname' => 'Max',
     					'Nachname' =>'Muster',
                   		'Geburtstag'=> 'dd',
                   		'Familienstand' => 'ledig',
                   		'Staatsbürgerschaft' => 'A',
                    	'Anschrift' => 'irgendwo',
                    	'Postleitzahl_ohne_A' => '1111',
                    	'Wohnort' => 'Wien',
						'Maturajahrgang' => '1234',
				    	'Berufserfahrung' => 'Ja',
				    	'Führerschein' => 'Nein',
				    	'Fremdsprachen' => 'Vielleicht',
				    	'Monat_Studienbeginn' => '1',
				    	'Jahr_Studenbeginn' => '90',
				    	'Studienrichtung' => 'dd',
				    	'Universität' => 'dd',  
				    	'Monat_der_Publikation' => '03',
				    	'Jahr_Publikation' => '00',
				    	'Autoren_der_Publikation' => 'autoren',
				    	'Name_der_Publikation' => 'name',
				    	'Ort_der_Publikation' => 'ort',
				    	'Land_der_Publikation' => 'land',
				    	'Ort' => 'ort');

   		$this->request->setMethod('POST')
                      ->setPost($array);
                      
       	$this->request->setHeaders(array('Accept-Charset' => 'utf-8'));
                      
    	foreach ($this->getRequest()->getHeaders() as $key=>$value)
        {
        	echo $key." ".$value;
        }

        $this->dispatch('/template/fillin/templateid/13');
    	
        $this->assertController('template');
        $this->assertAction('fillin');
        
        foreach ($this->getResponse()->getHeaders() as $key=>$value)
        {
        	echo $key." ".$value;
        }
        
        echo $this->getResponse()->getBody();
        
        $this->assertQueryCount('ul.errors', 1);
        
        
    }*/
    
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

