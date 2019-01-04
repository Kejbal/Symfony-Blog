<?php

namespace App\Tests\Admin;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AllPageTest extends WebTestCase
{

    /**
     * @dataProvider provideUrls
     */

    public function testPageIsSuccessful($url)
    {

        $client = self::createClient();
        $crawler = $client->request('GET', $url);

        $this->assertTrue($client->getResponse()->isSuccessful());

        $menu = new Menu();
        $menu->Menu($crawler);
    }

    public function provideUrls()
    {
        return array(
            array('admin/dashboard'),
            array('admin/app/blogpost/list'),
            array('admin/app/blogpost/create'),
            array('admin/app/category/list'),
            array('admin/app/category/create'),
        );
    }
}
