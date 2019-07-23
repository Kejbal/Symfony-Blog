<?php

namespace App\Tests\Admin;

use App\Entity\Config;
use App\Entity\GroupConfig;
use PHPUnit\Framework\TestCase;

class ConfigTest extends TestCase
{
    /**
     * @group entity
     * @group entity-config
     */

    public function testEntity()
    {
        $config = new Config();

        $config->getId();

        $config->setBase('Key');
        $this->assertEquals("Key", $config->getBase());

        $config->setValue('Value');
        $this->assertEquals("Value", $config->getValue());

        $group = new GroupConfig();
        $group->setName('test');
        $config->setGroupConfig($group);
        $this->assertEquals($group, $config->getGroupConfig());
    }
}
