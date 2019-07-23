<?php

namespace App\Tests\Controller;

use App\Controller\AdminLoginController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AdminLoginTest extends BaseWeb
{
    /**
     * @group controller
     * @group controller-admin-login
     * @group controller-admin-login-logout
     */

    public function testLogout()
    {
        $requestStack = new RequestStack;
        $authenticationUtils = new AuthenticationUtils($requestStack);

        $controller = new AdminLoginController($authenticationUtils);
        $this->assertNull($controller->logoutAction());
    }

    /**
     * @group controller
     * @group controller-admin-login
     * @group controller-admin-login-logout-code-200
     */

    public function testPageIsSuccessful()
    {
        $crawler = $this->client->request('GET', '/admin/logout');
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
    }

    /**
     * @group controller
     * @group controller-admin-login
     * @group controller-admin-login-login
     */

    public function testLogin()
    {
        $crawler = $this->client->request('GET', '/admin/login');
        $loginButton = $crawler->selectButton('Login');
        $form = $loginButton->form(array(
            'admin_login_form[email]' => 'fail@fail.com',
            'admin_login_form[password]' => 'fail',
        ));
        $crawler = $this->client->submit($form);
        $crawler = $this->client->request('GET', '/admin/login');
        $this->assertTrue($crawler->filter('html:contains("Username could not be found.")')->count() > 0);

        $loginButton = $crawler->selectButton('Login');
        $form = $loginButton->form(array(
            'admin_login_form[email]' => 'admin@admin.com',
            'admin_login_form[password]' => 'Rei8egh2',
        ));
        $crawler = $this->client->submit($form);
        $this->assertTrue($crawler->filter('html:contains("Redirecting to /admin/dashboard")')->count() > 0);
    }
}
