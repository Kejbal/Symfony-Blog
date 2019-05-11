<?php

namespace App\Tests\Admin;

use App\Entity\Language;
use PHPUnit\Framework\TestCase;

class LangaugeTest extends TestCase
{

    public function testEntity()
    {

        $language = new Language();

        $language->getId();

        $language->setName('Name');
        $this->assertEquals("Name", $language->getName());

        $language->setIsoCode('pl');
        $this->assertEquals('pl', $language->getIsoCode());

        $language->setStatus(1);
        $this->assertEquals(1, $language->getStatus());

    }
}
