<?php

namespace App\Tests\Admin;

class AllPageTest extends BaseWeb
{

    /**
     * @dataProvider provideUrls
     *
     * @group admin
     * @group admin-success
     */

    public function testPageIsSuccessful($url)
    {
        $crawler = $this->client->request('GET', $url);
        $this->assertTrue($this->client->getResponse()->isSuccessful());

        if ($url !== 'admin/login') {
            $menu = new Menu();
            $menu->Menu($crawler);
        }
    }

    public function provideUrls()
    {
        return array(
            array('admin/dashboard'),
            array('admin/app/blogpost/list'),
            array('admin/app/blogpost/create'),
            array('admin/app/category/list'),
            array('admin/app/category/create'),
            array('admin/login'),
        );
    }
}
