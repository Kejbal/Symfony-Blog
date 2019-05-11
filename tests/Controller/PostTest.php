<?php

namespace App\Tests\Controller;

use App\Entity\BlogPost;

class PostTest extends BaseWeb
{

    public function testPost()
    {
        $crawler = $this->_client->request('GET', '/post');

        $this->assertEquals(1, $crawler->filter('h1:contains("Sorry no Post on this url")')->count());

        $all_posts = self::$container->get('doctrine')->getRepository(BlogPost::class)->findBy([]);
        shuffle($all_posts);
        $random_posts = array_slice($all_posts, 0, 5);
        foreach ($random_posts as $post) {
            $crawler = $this->_client->request('GET', '/post/' . $post->getSlug());

            $this->assertEquals(1, $crawler->filter('h1:contains("' . $post->getTitle() . '")')->count());
            $this->assertEquals(1, $crawler->filter('h2.subheading:contains("' . $post->getSubTitle() . '")')->count());
            $this->assertEquals(1, $crawler->filter('span.meta:contains("' . $post->getDate()->format('H:i:s d M Y') . '")')->count());
            $this->assertNotEmpty($crawler->filter('div.mx-auto'));

        }

    }
}