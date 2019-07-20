<?php

namespace App\Tests\Controller;

use App\Entity\Category;
use App\Entity\User;
use App\Security\UserProvider;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserProviderTest extends KernelTestCase
{

    private $_userProvider;

    protected function setUp()
    {
        self::bootKernel();

        $em = self::$container->get('doctrine')->getManager();
        $this->_userProvider = new UserProvider($em);
    }

    /**
     * @group security
     * @group security-user-provider
     * @group security-user-provider-refresh-user
     * @group security-user-provider-refresh-user-exeption
     */

    public function testRefreshUserExeption()
    {
        $user = new User;

        try {

            $reloadedUser = $this->_userProvider->refreshUser($user);

        } catch (\Exception $e) {

            $this->assertEquals('User with ID "" could not be reloaded.', $e->getMessage());

        }

    }

    /**
     * @group security
     * @group security-user-provider
     * @group security-user-provider-supports-class
     */

    public function testSupportsClass()
    {
        $this->assertTrue($this->_userProvider->supportsClass(User::class));

        $this->assertFalse($this->_userProvider->supportsClass(Category::class));
    }

}