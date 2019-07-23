<?php

namespace App\Tests\Controller;

use App\Entity\User;
use App\Security\AdminLoginAuthenticator;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdminLoginAuthenticatorTest extends WebTestCase
{

    private $auth;

    protected function setUp()
    {
        self::bootKernel();

        $formFactory = self::$container->get('form.factory');
        $router = self::$container->get('router.default');
        $passwordEncoder = self::$container->get('security.user_password_encoder.generic');

        $this->auth = new AdminLoginAuthenticator($formFactory, $router, $passwordEncoder);
    }

    /**
     * @group security
     * @group security-admin-login-auth
     * @group security-admin-login-auth-check-credentials
     */

    public function testCheckCredentials()
    {
        $user = self::$container
            ->get('doctrine')
            ->getRepository(User::class)
            ->findOneBy(['email' => 'admin@admin.com']);

        $credentials['password'] = '';
        $valid = $this->auth->checkCredentials($credentials, $user);
        $this->assertFalse($valid);

        $credentials['password'] = 'Rei8egh2';
        $valid = $this->auth->checkCredentials($credentials, $user);
        $this->assertTrue($valid);

        try {
            $user->setRoles(array('ROLE_USER'));
            $valid = $this->auth->checkCredentials($credentials, $user);
        } catch (\Exception $e) {
            $this->assertEquals("You don't have permission to access that page.", $e->getMessage());
        }
    }

    /**
     * @group security
     * @group security-admin-login-auth
     * @group security-admin-login-auth-get-login-url
     */

    public function testGetLoginUrl()
    {
        self::bootKernel();
        $client = static::createClient();

        $loginUrl = $this->auth->getLoginUrl();
        $this->assertTrue(strpos($loginUrl, 'Redirecting to /admin/login') !== false);
    }
}
