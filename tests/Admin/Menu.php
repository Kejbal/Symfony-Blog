<?php

namespace App\Tests\Admin;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class Menu extends WebTestCase
{

    public function Menu($crawler)
    {
        $this->assertGreaterThan(
            0,
            $crawler->filter('a:contains("Category")')->count()
        );

        $this->assertEquals(
            '/admin/app/category/list',
            $crawler->filter('a:contains("Category")')->attr('href')
        );

        $this->assertGreaterThan(
            0,
            $crawler->filter('a:contains("Blog post")')->count()
        );

        $this->assertEquals(
            '/admin/app/blogpost/list',
            $crawler->filter('a:contains("Blog post")')->attr('href')
        );

    }
}
