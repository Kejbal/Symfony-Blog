<?php

namespace App\Tests\Admin;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class Menu extends WebTestCase
{

    public function menu($crawler)
    {
        $this->assertGreaterThan(
            0,
            $crawler->filter('.treeview-menu > li > a:contains("Category")')->count()
        );
        $this->assertEquals(
            '/admin/app/category/list',
            $crawler->filter('.treeview-menu > li > a:contains("Category")')->attr('href')
        );
        $this->assertGreaterThan(
            0,
            $crawler->filter('.treeview-menu > li > a:contains("Blog post")')->count()
        );
        $this->assertEquals(
            '/admin/app/blogpost/list',
            $crawler->filter('.treeview-menu > li > a:contains("Blog post")')->attr('href')
        );
        $this->assertGreaterThan(
            0,
            $crawler->filter('.treeview-menu > li > a:contains("User")')->count()
        );

        $this->assertEquals(
            '/admin/app/user/list',
            $crawler->filter('.treeview-menu > li > a:contains("User")')->attr('href')
        );
        $this->assertGreaterThan(
            0,
            $crawler->filter('.treeview-menu > li > a:contains("Language")')->count()
        );
        $this->assertEquals(
            '/admin/app/language/list',
            $crawler->filter('.treeview-menu > li > a:contains("Language")')->attr('href')
        );
    }
}
