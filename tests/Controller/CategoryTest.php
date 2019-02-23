<?php

namespace App\Tests\Controller;

use App\Entity\BlogPost;
use App\Entity\Category;

class CategoryTest extends BaseWeb
{

    public function testCategory()
    {
        $per_page = 5;

        $categories = self::$container->get('doctrine')->getRepository(Category::class)->findAll();

        foreach ($categories as $category) {
            $all_posts = self::$container->get('doctrine')->getRepository(BlogPost::class)->findBy(['draft' => '0', 'category' => $category->getId()], ['id' => 'DESC']);

            $number_page = ceil(count($all_posts) / $per_page);

            if (count($all_posts) > 0) {
                for ($page = 1; $page <= $number_page; $page++) {
                    $crawler = $this->client->request('GET', '/category/' . $category->getId() . '/' . $page
                    );

                    $posts = self::$container->get('doctrine')->getRepository(BlogPost::class)->findBy(['draft' => '0', 'category' => $category->getId()], ['id' => 'DESC'], $per_page, ($page - 1) * $per_page);

                    foreach ($posts as $post) {
                        $this->assertEquals(1, $crawler->filter('h2.post-title:contains("' . $post->getTitle() . '")')->count());
                        $this->assertEquals(1, $crawler->filter('h3.post-subtitle:contains("' . $post->getSubtitle() . '")')->count());
                        $this->assertEquals(1, $crawler->filter('p.post-meta:contains("' . $post->getDate()->format('H:i:s d M Y') . '")')->count());
                    }

                    if ($page > 1) {
                        $this->assertEquals(1, $crawler->filter('#newer-posts:contains("Newer Posts")')->count());
                        $newer_page = $page - 1;
                        $this->assertContains(
                            '/category/' . $category->getId() . '/' . $newer_page,
                            $crawler->filter('#newer-posts a:contains("Newer Posts")')->attr('href')
                        );
                    }

                    if ($page < $number_page) {
                        $this->assertEquals(1, $crawler->filter('#older-posts:contains("Older Posts")')->count());
                        $older_page = $page + 1;
                        $this->assertContains(
                            '/category/' . $category->getId() . '/' . $older_page,
                            $crawler->filter('#older-posts a:contains("Older Posts")')->attr('href')
                        );
                    }
                }
            }
        }

    }
}