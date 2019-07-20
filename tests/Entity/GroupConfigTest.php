<?php

namespace App\Tests\Entity;

use App\Entity\Config;
use App\Entity\GroupConfig;
use Doctrine\Common\Collections\Collection;
use PHPUnit\Framework\TestCase;

class GroupConfigTest extends TestCase
{
    /**
     * @group entity
     * @group entity-group-config
     */

    public function testEntity()
    {

        $group = new GroupConfig();

        $this->assertNull($group->getId());

        $group->setName('Name');
        $this->assertEquals("Name", $group->getName());
        $this->assertTrue($group->getConfigs() instanceof Collection);
        $this->assertEmpty($group->getConfigs());

        $config = new Config();
        $config->setBase('Key');
        $config->setValue('Value');
        $group->addConfig($config);

        $this->assertTrue($group->getConfigs() instanceof Collection);
        $this->assertEquals(1, count($group->getConfigs()));

        $group->removeConfig($config);

        $this->assertTrue($group->getConfigs() instanceof Collection);
        $this->assertEmpty($group->getConfigs());

    }
}