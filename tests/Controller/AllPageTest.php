<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AllPageTest extends WebTestCase
{

    /**
     * @dataProvider provideUrls
     */

    public function testPageIsSuccessful($url)
    {
        self::bootKernel();
        $client = static::createClient();
        $crawler = $client->request('GET', $url);

        $this->assertTrue($client->getResponse()->isSuccessful());

        $menu = new Menu();
        $menu->Menu($crawler);
    }

    public function provideUrls()
    {
        return array(
            array(''),
            array('/category'),
        );
    }

}