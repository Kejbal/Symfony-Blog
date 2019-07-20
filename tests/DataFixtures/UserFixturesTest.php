<?php

namespace App\Tests\Controller;

use App\DataFixtures\UserFixtures;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserFixturesTest extends KernelTestCase
{
    /**
     * @group data-fixtures
     * @group data-fixtures-user-fixtures
     * @group data-fixtures-user-fixtures-load
     */

    public function testLoad()
    {
        self::bootKernel();
        $manager = $this->createMock(ObjectManager::class);
        $passwordEncoder = self::$container->get('security.password_encoder');
        $fixture = new UserFixtures($passwordEncoder);

        $this->assertNull($fixture->load($manager));
    }

}