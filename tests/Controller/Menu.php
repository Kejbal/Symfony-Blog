<?php

namespace App\Tests\Controller;

use App\Entity\BlogPost;
use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class Menu extends WebTestCase
{

    public function Menu($crawler, $client)
    {

        $locale = $client->getRequest()->getLocale();

        if ($locale === 'en') {

            $this->assertGreaterThan(
                0,
                $crawler->filter('.nav-link:contains("Home")')->count()
            );

            $this->assertEquals(
                'http://localhost/',
                $crawler->filter('.nav-link:contains("Home")')->attr('href')
            );

            $this->assertGreaterThan(
                0,
                $crawler->filter('.nav-link:contains("Contact")')->count()
            );

            $this->assertEquals(
                'http://localhost/contact',
                $crawler->filter('.nav-link:contains("Contact")')->attr('href')
            );

        } elseif ($locale === 'pl') {

            $this->assertGreaterThan(
                0,
                $crawler->filter('.nav-link:contains("Strona Główna")')->count()
            );

            $this->assertEquals(
                'http://localhost/pl',
                $crawler->filter('.nav-link:contains("Strona Główna")')->attr('href')
            );

            $this->assertGreaterThan(
                0,
                $crawler->filter('.nav-link:contains("Kontakt")')->count()
            );

            $this->assertEquals(
                'http://localhost/kontakt',
                $crawler->filter('.nav-link:contains("Kontakt")')->attr('href')
            );

        }

        $categories = self::$container->get('doctrine')->getRepository(Category::class)->findBy(array());

        foreach ($categories as $category) {
            $post = self::$container->get('doctrine')->getRepository(BlogPost::class)->findOneBy(array('category' => $category->getId()));

            if ($post) {
                $manu_links[] = $category;
            }
        }
        if ($locale === 'en') {
            foreach ($manu_links as $manu_link) {

                $this->assertGreaterThan(
                    0,
                    $crawler->filter('.nav-link:contains("' . $manu_link->getName() . '")')->count()
                );

                $this->assertEquals(
                    'http://localhost/category/' . $manu_link->getSlug(),
                    $crawler->filter('.nav-link:contains("' . $manu_link->getName() . '")')->attr('href')
                );
            }
        } else {
            foreach ($manu_links as $manu_link) {

                $this->assertGreaterThan(
                    0,
                    $crawler->filter('.nav-link:contains("' . $manu_link->getName() . '")')->count()
                );

                $this->assertEquals(
                    'http://localhost/kategoria/' . $manu_link->getSlug(),
                    $crawler->filter('.nav-link:contains("' . $manu_link->getName() . '")')->attr('href')
                );
            }
        }

    }
}