<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BaseWeb extends WebTestCase
{

    protected $_client;
    public $locale;

    public function setUp()
    {
        self::bootKernel();
        $client = static::createClient();
        $this->_client = $client;
    }
}