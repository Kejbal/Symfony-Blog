<?php

namespace App\Tests\Controller;

use App\Entity\BlogPost;

class IndexTest extends BaseWeb
{

    public function testHome()
    {
        $per_page = 5;

        $crawler = $this->client->request('GET', '/');

        $posts = self::$container->get('doctrine')->getRepository(BlogPost::class)->findBy(['draft' => '0'], ['id' => 'DESC'], $per_page);

        foreach ($posts as $post) {

            $this->assertEquals(1, $crawler->filter('h2.post-title:contains("' . $post->getTitle() . '")')->count());
            $this->assertEquals(1, $crawler->filter('h3.post-subtitle:contains("' . $post->getSubtitle() . '")')->count());
            $this->assertEquals(1, $crawler->filter('p.post-meta:contains("' . $post->getDate()->format('H:i:s d M Y') . '")')->count());
        }

        $all_posts = self::$container->get('doctrine')->getRepository(BlogPost::class)->findBy(['draft' => '0']);
        if (count($all_posts) > $per_page) {
            $this->assertEquals(1, $crawler->filter('#older-posts:contains("Older Posts")')->count());
            $this->assertEquals(
                '/2',
                $crawler->filter('#older-posts a:contains("Older Posts")')->attr('href')
            );

            $number_page = ceil(count($all_posts) / $per_page);

            for ($page = 2; $page <= $number_page; $page++) {
                $crawler = $this->client->request('GET', '/' . $page
                );

                $posts = self::$container->get('doctrine')->getRepository(BlogPost::class)->findBy(['draft' => '0'], ['id' => 'DESC'], $per_page, ($page - 1) * $per_page);

                foreach ($posts as $post) {
                    $this->assertEquals(1, $crawler->filter('h2.post-title:contains("' . $post->getTitle() . '")')->count());
                    $this->assertEquals(1, $crawler->filter('h3.post-subtitle:contains("' . $post->getSubtitle() . '")')->count());
                    $this->assertEquals(1, $crawler->filter('p.post-meta:contains("' . $post->getDate()->format('H:i:s d M Y') . '")')->count());
                }

                $this->assertEquals(1, $crawler->filter('#newer-posts:contains("Newer Posts")')->count());
                $newer_page = $page - 1;
                $this->assertEquals(
                    '/' . $newer_page,
                    $crawler->filter('#newer-posts a:contains("Newer Posts")')->attr('href')
                );

                if ($page < $number_page) {
                    $this->assertEquals(1, $crawler->filter('#older-posts:contains("Older Posts")')->count());
                    $older_page = $page + 1;
                    $this->assertEquals(
                        '/' . $older_page,
                        $crawler->filter('#older-posts a:contains("Older Posts")')->attr('href')
                    );
                }
            }

        }

    }
}