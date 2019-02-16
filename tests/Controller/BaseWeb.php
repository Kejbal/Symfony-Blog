<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BaseWeb extends WebTestCase
{

    protected $client;

    public function setUp()
    {
        self::bootKernel();
        $client = static::createClient();
        $this->client = $client;
    }
}