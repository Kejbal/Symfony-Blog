<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class Menu extends WebTestCase
{

    public function Menu($crawler)
    {
        $this->assertGreaterThan(
            0,
            $crawler->filter('.nav-link:contains("Home")')->count()
        );

        $this->assertEquals(
            '/',
            $crawler->filter('.nav-link:contains("Home")')->attr('href')
        );

    }
}