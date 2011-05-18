<?php

require_once 'BaseTestCase.php';

class AccountControllerTest extends ControllerTestCase
{
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
 
    public function testRegistrationShouldFailWithInvalidData()
    {
        $data = array(
            'username' => 'This will not work',
            'email'    => 'this is an invalid email',
            'password' => 'Th1s!s!nv@l1d',
        );
        $request = $this->getRequest();
        $request->setMethod('POST')
                ->setPost($data);
        $this->dispatch('/account/register');
        $this->assertNotRedirect();
        $this->assertQuery('form .errors');
    }
}