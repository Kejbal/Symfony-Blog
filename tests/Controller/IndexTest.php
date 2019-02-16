<?php

namespace App\Tests\Controller;

use App\Entity\BlogPost;

class IndexTest extends BaseWeb
{
    public function testHome()
    {

        $crawler = $this->client->request('GET', '/');

        $posts = self::$container->get('doctrine')->getRepository(BlogPost::class)->findBy(['draft' => '0'], ['id' => 'DESC'], 5);

        foreach ($posts as $post) {

            $this->assertEquals(1, $crawler->filter('h2.post-title:contains("' . $post->getTitle() . '")')->count());
            $this->assertEquals(1, $crawler->filter('h3.post-subtitle:contains("' . $post->getSubtitle() . '")')->count());
            $this->assertEquals(1, $crawler->filter('p.post-meta:contains("' . $post->getDate()->format('H:i:s d M Y') . '")')->count());
        }
    }
}