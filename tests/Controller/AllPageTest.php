<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AllPageTest extends WebTestCase
{

    /**
     * @dataProvider provideUrls
     *
     * @group controller
     * @group controller-success
     */

    public function testPageIsSuccessful($url)
    {
        self::bootKernel();
        $client = static::createClient();
        $crawler = $client->request('GET', $url);

        $this->assertTrue($client->getResponse()->isSuccessful());

        if ($url !== '/admin/login') {
            $menu = new Menu();
            $menu->Menu($crawler, $client);
        }

    }

    public function provideUrls()
    {
        return array(
            array(''),
            array('/category'),
            array('/post'),
            array('/contact'),
            array('/pl'),
            array('/kategoria'),
            array('/wpis'),
            array('/kontakt'),
            array('/admin/login'),
        );
    }

}