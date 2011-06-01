<?php

require_once 'BaseTestCase.php';

class AccountControllerTest extends ControllerTestCase
{
    public function testLoginAction()
    {
        $this->dispatch('/account/login');
        
        $this->assertController('account');
        $this->assertAction('login');
    }
    
	public function testCallWithoutActionShouldPullFromIndexAction()
    {
        $this->dispatch('/account');
        $this->assertController('account');
        $this->assertAction('index');
    }
 
    public function testLoginFormShouldContainLoginForm()
    {
        $this->dispatch('/account/login');
        $this->assertQueryCount('form', 1);
    }
    
	public function testInvalidCredentialsShouldResultInRedisplayOfLoginForm()
    {
        $request = $this->getRequest();
        $request->setMethod('POST')
                ->setPost(array(
                    'username' => 'bogus',
                    'password' => 'reallyReallyBogus',
                ));
        $this->dispatch('/account/login');
        $this->assertNotRedirect();
        $this->assertQuery('form');
    }
    
	public function testValidLoginShouldRedirectToIndexPage()
    {
        $this->loginUser('bernd', 'hirschmann');
    }
 
    public function testAuthenticatedUsersShouldBeRedirectedToIndexPageWhenVisitingLogin()
    {
        $this->loginUser('bernd', 'hirschmann');
        $this->request->setMethod('GET');
        $this->dispatch('/account/login');
        $this->assertRedirectTo('/');
    }
 
    public function testUserShouldRedirectToLoginPageOnLogout()
    {
        $this->loginUser('bernd', 'hirschmann');
        $this->request->setMethod('GET');
        $this->dispatch('/account/logout');
        $this->assertRedirectTo('/account/login');
    }
 
    public function testRegisterAction()
    {
    	$this->dispatch('/account/register');
        
        $this->assertController('account');
        $this->assertAction('register');
    }
    
	public function testRegisterFormShouldContainLoginForm()
    {
        $this->dispatch('/account/register');
        $this->assertQueryCount('form', 1);
    }
    
    public function testRegistrationShouldFailWithInvalidData()
    {
        $data = array(
            'username' => 'This will not work',
            'password' => 'Th1s!s!nv@l1d',
            'email'    => 'this is an invalid email',
        );
        $request = $this->getRequest();
        $request->setMethod('POST')
                ->setPost($data);
        $this->dispatch('/account/register');
        $this->assertNotRedirect();
        $this->assertQuery('form .errors');
    }
    
    public function testSuccessfulRegistrationShouldRedirectToIndexPage()
    {
    	$data = array(
            'username' => 'katharina',
    	    'password' => 'stadlmayr',
            'email'    => 'katharina@stadlmayr.com',
    		'name'	   => 'katharina',
    		'lastname' => 'stadlmayr',
        );
        $request = $this->getRequest();
        $request->setMethod('POST')
                ->setPost($data);
        $this->dispatch('/account/register');
        $this->assertRedirectTo('/');
    }
    
    public function testRegistrationIfLoggedInShouldRedirectToIndexPage()
    {
    	$this->loginUser('bernd', 'hirschmann');
    	
        $this->dispatch('/account/register');
        $this->assertRedirectTo('/');
    }
    
}