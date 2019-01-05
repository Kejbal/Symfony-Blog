<?php

namespace App\Tests\Admin;

use App\Entity\Category;
use App\Tests\Admin\BlogPostAdminTest;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CategoryAdminTest extends WebTestCase
{

    public function testList()
    {

        self::bootKernel();

        $category = self::$container->get('doctrine')->getRepository(Category::class)->findOneBy(array());

        $client = static::createClient();

        $crawler = $client->request('GET', 'admin/app/category/list');

        if (!$category) {

            $this->assertGreaterThan(
                0,
                $crawler->filter('a:contains("Add new")')->count()
            );

        } else {

            $this->assertGreaterThan(
                0,
                $crawler->filter('a:contains("Name")')->count()
            );

        }

    }

    public function testAddEdit()
    {

        self::bootKernel();

        $client = static::createClient();
        $crawler = $client->request('GET', 'admin/app/category/create');

        $send_button = $crawler->selectButton('Create');

        $form = $send_button->form(array(
            'sec4809de79[name]' => 'Test',
        ));

        $crawler = $client->submit($form);

        $category = self::$container->get('doctrine')->getRepository(Category::class)->findOneBy(array('name' => 'Test'));
        $this->assertTrue(!empty($category));

        $this->assertTrue($crawler->filter('html:contains("Redirecting to")')->count() > 0);

        $link = $crawler->filter('a')->attr('href');

        $crawler = $client->request('GET', $link);

        $send_button = $crawler->selectButton('Update');

        $form = $send_button->form(array(
            'sec4809de79[name]' => 'Hu4thahr',
        ));

        $crawler = $client->submit($form);

        $category = self::$container->get('doctrine')->getRepository(Category::class)->findOneBy(array('name' => 'Hu4thahr'));
        $this->assertTrue(!empty($category));

        $blogPostTest=new BlogPostAdminTest();
        $blogPostTest->AddEdit();

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

        $category = self::$container->get('doctrine')->getRepository(Category::class)->findOneBy(array('name' => 'thiX4sei'));
        $this->assertTrue(!$category);

    }

}