<?php

namespace App\Tests\Controller;

use App\Entity\BlogPost;
use App\Entity\Category;
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

        $categories = self::$container->get('doctrine')->getRepository(Category::class)->findBy(array());

        foreach ($categories as $category) {
            $post = self::$container->get('doctrine')->getRepository(BlogPost::class)->findOneBy(array('category' => $category->getId()));

            if ($post) {
                $manu_links[] = $category;
            }
        }

        foreach ($manu_links as $manu_link) {

            $this->assertGreaterThan(
                0,
                $crawler->filter('.nav-link:contains("' . $manu_link->getName() . '")')->count()
            );

            $this->assertEquals(
                '/category/post/' . $manu_link->getId(),
                $crawler->filter('.nav-link:contains("' . $manu_link->getName() . '")')->attr('href')
            );
        }

    }
}