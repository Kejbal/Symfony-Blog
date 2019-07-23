<?php

namespace App\Tests\Controller;

use App\Entity\BlogPost;
use App\Entity\Language;

class PostTest extends BaseWeb
{
    /**
     * @group controller
     * @group controller-post
     */

    public function testPost()
    {
        $languages = self::$container->get('doctrine')->getRepository(Language::class)->findBy(['status' => '1']);

        foreach ($languages as $language) {

            if ($language->getIsoCode() == 'en') {
                $crawler = $this->_client->request('GET', '/post');
                $this->assertEquals(1, $crawler->filter('h1:contains("Sorry no Post on this url")')->count());
            } elseif ($language->getIsoCode() == 'pl') {
                $crawler = $this->_client->request('GET', '/wpis');
                $this->assertEquals(1, $crawler->filter('h1:contains("Przepraszamy ale nia ma wpisu pod tym adresem")')->count());
            }

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
}