<?php

namespace App\Tests\Admin;

use App\Entity\BlogPost;
use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BlogPostAdminTest extends WebTestCase
{

    public function testList()
    {

        self::bootKernel();

        $post = self::$container->get('doctrine')->getRepository(BlogPost::class)->findOneBy(array());

        $client = static::createClient();

        $crawler = $client->request('GET', 'admin/app/blogpost/list');

        if (!$post) {

            $this->assertGreaterThan(
                0,
                $crawler->filter('a.sonata-action-element:contains("Add new")')->count()
            );

        } else {

            $this->assertGreaterThan(
                0,
                $crawler->filter('th:contains("Category Name")')->count()
            );

            $this->assertGreaterThan(
                0,
                $crawler->filter('th:contains("Title")')->count()
            );

        }

        $this->assertGreaterThan(
            0,
            $crawler->filter('a.sonata-toggle-filter:contains("Title")')->count()
        );

        $this->assertGreaterThan(
            0,
            $crawler->filter('a.sonata-toggle-filter:contains("Category Name")')->count()
        );

    }

    public function AddEdit()
    {
        self::bootKernel();

        $category = self::$container->get('doctrine')->getRepository(Category::class)->findOneBy(array());

        $client = static::createClient();
        $crawler = $client->request('GET', 'admin/app/blogpost/create');

        $category_id = $category->getId();

        $send_button = $crawler->selectButton('Create');

        $form = $send_button->form(array(
            's5d37a1acbf[title]' => 'Meik8ree',
            's5d37a1acbf[body]' => '<div>test</div>',
            's5d37a1acbf[category]' => $category_id,
            's5d37a1acbf[draft]' => true,
        ));
        $crawler = $client->submit($form);

        $post = self::$container->get('doctrine')->getRepository(BlogPost::class)->findOneBy(array('title' => 'Meik8ree', 'category' => $category_id));
        $this->assertTrue(!empty($post));

        $this->assertTrue($crawler->filter('html:contains("Redirecting to")')->count() > 0);

        $link = $crawler->filter('a')->attr('href');
        $crawler = $client->request('GET', $link);

        $send_button = $crawler->selectButton('Update');
        $form = $send_button->form(array(
            's5d37a1acbf[title]' => 'Aaphoo9k',
            's5d37a1acbf[body]' => '<div>test</div>',
            's5d37a1acbf[category]' => $category_id,
            's5d37a1acbf[draft]' => true,
        ));
        $crawler = $client->submit($form);

        $post = self::$container->get('doctrine')->getRepository(BlogPost::class)->findOneBy(array('title' => 'Aaphoo9k', 'category' => $category_id));
        $this->assertTrue(!empty($post));

        $this->assertTrue($crawler->filter('html:contains("Redirecting to")')->count() > 0);

        $link = $crawler->filter('a')->attr('href');
        $crawler = $client->request('GET', $link);

        $button = $crawler
            ->filter('a:contains("Delete")')
            ->eq(0)
            ->link();

        $crawler = $client->click($button);

        $send_button = $crawler->selectButton('Yes, delete');

        $form = $send_button->form();

        $crawler = $client->submit($form);

        $this->assertTrue($crawler->filter('html:contains("Redirecting to")')->count() > 0);

        $post = self::$container->get('doctrine')->getRepository(BlogPost::class)->findOneBy(array('title' => 'Aaphoo9k', 'category' => $category_id));
        $this->assertTrue(!$post);

    }

}