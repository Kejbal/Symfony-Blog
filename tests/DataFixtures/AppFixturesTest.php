<?php

namespace App\Tests\Controller;

use App\DataFixtures\AppFixtures;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class AppFixturesTest extends KernelTestCase
{
    /**
     * @group data-fixtures
     * @group data-fixtures-app-fixtures
     * @group data-fixtures-app-fixtures-load
     */

    public function testLoad()
    {
        self::bootKernel();
        $manager = self::$container->get('doctrine')->getManager();

        $fixture = new AppFixtures;
        $this->assertNull($fixture->load($manager));
    }

}